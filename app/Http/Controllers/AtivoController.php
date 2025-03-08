<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Ativo;
use App\Models\AtivoLocal;
use App\Models\Marca;
use App\Models\Tipo;
use App\Models\Local;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;

class AtivoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Carrega apenas os campos necessários nos relacionamentos, especificando a tabela
        $query = Ativo::with([
            'marca' => function ($query) {
                $query->select('marcas.id', 'marcas.descricao');
            },
            'tipo' => function ($query) {
                $query->select('tipos.id', 'tipos.descricao');
            },
            'local' => function ($query) {
                $query->select('locais.id', 'locais.descricao');
            },
            'user' => function ($query) {
                $query->select('users.id', 'users.name');
            }
        ])->orderBy('created_at', 'desc');

        // Pega o usuário autenticado atual
        $user = auth()->user();
        $userName = $user ? $user->name : 'Usuário não autenticado';

        // Log com o termo de pesquisa e nome do usuário
        \Log::info('Pesquisa realizada em ativos:', [
            'termo' => $search,
            'user' => $userName
        ]);

        // Aplica o filtro de busca
        if ($request->filled('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('descricao', 'like', "%{$search}%")
                    ->orWhere('observacao', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('quantidade', '=', (int) $search)
                    ->orWhere('quantidade_min', '=', (int) $search)
                    ->orWhere('id_marca', '=', (int) $search)
                    ->orWhere('id_tipo', '=', (int) $search)
                    ->orWhere('id_user', '=', (int) $search)
                    ->orWhereHas('marca', function ($subQuery) use ($search) {
                        $subQuery->where('descricao', 'like', "%{$search}%");
                    })
                    ->orWhereHas('tipo', function ($subQuery) use ($search) {
                        $subQuery->where('descricao', 'like', "%{$search}%");
                    })
                    ->orWhereHas('user', function ($subQuery) use ($search) {
                        $subQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $ativos = $query->paginate(50)->appends($request->all());

        $marcas = Marca::all();
        $tipos = Tipo::all();

        $ativosDisp = DB::table('ativo_local')
            ->select('id_ativo', DB::raw('SUM(quantidade) AS quantidade_disp'))
            ->where('id_local', '=', 1)
            ->groupBy('id_ativo')
            ->get();

        return view('ativos.index', compact('ativos', 'marcas', 'tipos', 'ativosDisp'));
    }

    // public function show($id)
    // {
    //     $ativo = Ativo::findOrFail($id);
    //     return response()->json($ativo);
    // }

    public function showDetails($id)
    {
        $ativo = Ativo::with('movimentacoes', 'local')->findOrFail($id); // Corrigido 'locais'
        $marcas = Marca::all();
        $tipos = Tipo::all();

        // Obter a quantidade disponível no local específico
        $ativosDisp = DB::table('ativo_local')
            ->select('id_ativo', DB::raw('SUM(quantidade) AS quantidade_disp'))
            ->where('id_local', '=', 1)
            ->groupBy('id_ativo')
            ->get();

        $movimentacoes = $ativo->movimentacoes;
        $locais = $ativo->locais; // Corrigido para corresponder ao modelo atualizado

        return view('ativos.show', compact('ativo', 'marcas', 'tipos', 'ativosDisp', 'movimentacoes', 'locais'));
    }



    public function show($id)
    {
        $ativo = Ativo::findOrFail($id);
        return response()->json($ativo);
    }


    // public function search(Request $request)
    // {
    //     $search = $request->input('search');

    //     $query = Ativo::with(['marca', 'tipo', 'local', 'user'])
    //         ->orderBy('created_at', 'desc');

    //     if ($search) {
    //         $query->where(function ($q) use ($search) {
    //             $q->where('descricao', 'like', '%' . $search . '%')
    //                 ->orWhere('observacao', 'like', '%' . $search . '%')
    //                 ->orWhere('status', 'like', '%' . $search . '%')
    //                 ->orWhere('id_marca', '=', (int) $search)
    //                 ->orWhere('id_tipo', '=', (int) $search)
    //                 ->orWhere('id_user', '=', (int) $search);
    //         });
    //     }

    //     // Substituí get() por paginate() para habilitar links()
    //     $ativos = $query->paginate(10);

    //     // Mantive suas outras variáveis
    //     $marcas = Marca::all();
    //     $tipos = Tipo::all();

    //     $ativosDisp = DB::table('ativo_local')
    //         ->select('id_ativo', DB::raw('SUM(quantidade) AS quantidade_disp'))
    //         ->where('id_local', '=', 1)
    //         ->groupBy('id_ativo')
    //         ->get();

    //     return view('ativos.index', compact('ativos', 'marcas', 'tipos', 'ativosDisp'));
    // }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'descricao' => 'required|string|max:255',
                'quantidade' => 'required|integer|min:1',
                'quantidade_min' => 'nullable|integer|min:1',
                'observacao' => 'nullable|string',
                'id_marca' => 'nullable|exists:marcas,id',
                'id_tipo' => 'nullable|exists:tipos,id',
                'nova_marca' => 'nullable|string|max:255|exclude_if:id_marca,!=,null',
                'novo_tipo' => 'nullable|string|max:255|exclude_if:id_tipo,!=,null',
                'imagem' => 'nullable|image|max:2048',
            ]);

            // Processar nova marca/tipo
            $id_marca = $this->processarMarca($request);
            $id_tipo = $this->processarTipo($request);

            // Upload de imagem com tratamento de erro
            try {
                $imagemPath = $this->uploadImagem($request);
            } catch (Exception $e) {
                return redirect()->back()
                    ->withErrors(['imagem' => $e->getMessage()])
                    ->withInput();
            }

            // Criar ativo
            $ativo = Ativo::create([
                'descricao' => $request->descricao,
                'quantidade' => $request->quantidade,
                'quantidade_min' => $request->quantidade_min,
                'status' => 1,
                'observacao' => $request->observacao,
                'id_marca' => $id_marca,
                'id_tipo' => $id_tipo,
                'id_user' => $request->user()->id,
                'imagem' => $imagemPath,
            ]);

            // Criar vínculo do ativo com o local, utilizando a quantidade total
            AtivoLocal::create([
                'id_ativo' => $ativo->id,
                'id_local' => $request->id_local, // local padrão: 1 (almoxarifado)
                'quantidade' => $request->quantidade, // Atribui a quantidade total ao local fixo
            ]);

            // Adicionar log de sucesso
            Log::info('Ativo cadastrado com sucesso. Descrição: ' . $ativo->descricao . ' ID: ' . $ativo->id);

            return redirect()->route('ativos.index')
                ->with('success', 'Ativo cadastrado com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro ao cadastrar ativo: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Erro ao cadastrar ativo: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info("Iniciando atualização do ativo ID: {$id}", ['request_data' => $request->all()]);

            $request->validate([
                'descricao' => 'required|string|max:255',
                'quantidade' => 'required|integer|min:1',
                'quantidade_min' => 'nullable|integer|min:1',
                'observacao' => 'nullable|string',
                'id_marca' => 'required|exists:marcas,id',
                'id_tipo' => 'required|exists:tipos,id',
                'status' => 'required|boolean',
                'imagem' => 'nullable|image|max:2048',
            ]);

            $ativo = Ativo::findOrFail($id);
            Log::info("Ativo encontrado", ['ativo' => $ativo->toArray()]);

            $dados = $request->only([
                'descricao',
                'quantidade',
                'quantidade_min',
                'observacao',
                'id_marca',
                'id_tipo',
                'status',
            ]);

            // Atualizar a quantidade
            $dados['quantidade'] = max(0, $request->quantidade);
            $dados['quantidade_min'] = $request->quantidade_min !== null ? max(0, $request->quantidade_min) : null;
            Log::info("Dados extraídos para atualização", ['dados' => $dados]);


            // Fluxo seguro para substituição de imagem
            if ($request->hasFile('imagem')) {
                try {
                    Log::info("Imagem enviada, iniciando upload");
                    $novaImagem = $this->uploadImagem($request);
                    Log::info("Imagem enviada com sucesso", ['nova_imagem' => $novaImagem]);

                    $this->deletarImagemAntiga($ativo->imagem);
                    Log::info("Imagem antiga deletada", ['imagem_antiga' => $ativo->imagem]);

                    $dados['imagem'] = $novaImagem;
                } catch (Exception $e) {
                    Log::error("Erro no upload da imagem: " . $e->getMessage());
                    return redirect()->back()
                        ->withErrors(['imagem' => $e->getMessage()])
                        ->withInput();
                }
            }

            // Atualiza o ativo no banco
            Log::info("Atualizando ativo no banco...");
            $ativo->update($dados);
            Log::info("Ativo atualizado com sucesso", ['ativo_atualizado' => $ativo->toArray()]);

            // Atualizar o vínculo do ativo no local
            $ativoLocal = AtivoLocal::where('id_ativo', $id)->first();
            if ($ativoLocal) {
                Log::info("Ativo encontrado no AtivoLocal, atualizando quantidade", ['ativo_local' => $ativoLocal->toArray()]);
                $ativoLocal->quantidade = $request->quantidade;
                $ativoLocal->save();
                Log::info("Quantidade do AtivoLocal atualizada", ['novo_valor' => $ativoLocal->quantidade]);
            } else {
                Log::warning("AtivoLocal não encontrado para o ativo ID: {$id}");
            }

            return redirect()->route('ativos.index')
                ->with('success', 'Ativo atualizado com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro ao atualizar ativo: ' . $e->getMessage(), ['stack' => $e->getTraceAsString()]);
            return redirect()->back()
                ->withErrors(['error' => 'Erro ao atualizar ativo: ' . $e->getMessage()])
                ->withInput();
        }
    }



    public function destroy($id)
    {
        try {
            $ativo = Ativo::findOrFail($id);

            // Remover relacionamentos
            $ativo->local()->delete();

            // Deletar imagem
            $this->deletarImagemAntiga($ativo->imagem);

            $ativo->delete();

            Log::info('Ativo excluido com sucesso.');

            return response()->json([
                'success' => true,
                'message' => 'Ativo excluído com sucesso!'
            ]);
        } catch (Exception $e) {
            Log::error('Erro ao excluir ativo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir ativo!'
            ], 500);
        }
    }

    // Métodos auxiliares
    private function processarMarca(Request $request)
    {
        if ($request->filled('nova_marca')) {
            $marca = Marca::firstOrCreate(['descricao' => $request->nova_marca]);
            return $marca->id;
        }
        return $request->id_marca;
    }

    private function processarTipo(Request $request)
    {
        if ($request->filled('novo_tipo')) {
            $tipo = Tipo::firstOrCreate(['descricao' => $request->novo_tipo]);
            return $tipo->id;
        }
        return $request->id_tipo;
    }

    private function uploadImagem(Request $request)
    {
        try {
            if (!$request->hasFile('imagem')) {
                return null;
            }

            $imagem = $request->file('imagem');

            // Gera nome único para o arquivo
            $nomeArquivo = 'ativo-' . uniqid() . '.' . $imagem->getClientOriginalExtension();

            // Faz upload para a pasta específica
            $caminho = $imagem->storeAs(
                'ativos',
                $nomeArquivo,
                'public'
            );

            Log::info('Upload de imagem realizado', ['caminho' => $caminho]);
            return $caminho;
        } catch (Exception $e) {
            Log::error('Falha no upload de imagem', [
                'erro' => $e->getMessage(),
                'arquivo' => $imagem->getClientOriginalName()
            ]);
            throw new Exception('Falha ao realizar upload da imagem');
        }
    }

    private function deletarImagemAntiga($path)
    {
        try {
            if (!$path) {
                return;
            }

            $disco = Storage::disk('public');

            if ($disco->exists($path)) {
                $disco->delete($path);
                Log::info('Imagem antiga removida', ['caminho' => $path]);
            }
        } catch (Exception $e) {
            Log::error('Falha ao remover imagem antiga', [
                'erro' => $e->getMessage(),
                'caminho' => $path
            ]);
            throw new Exception('Falha ao remover imagem anterior');
        }
    }


    public function getLocaisDisponiveis($ativoId)
    {
        // Buscar o ativo pelo ID
        $ativo = Ativo::find($ativoId);

        // Verificar se o ativo existe
        if (!$ativo) {
            Log::warning("Ativo não encontrado: ID {$ativoId}");
        }

        // Obter os locais e formatar a resposta concatenando descrição e quantidade
        $locais = $ativo->local()
            ->select('locais.id', 'locais.descricao', 'ativo_local.quantidade')
            ->where('ativo_local.id_ativo', $ativoId)
            ->where('ativo_local.quantidade', '>', 0) // Filtra locais com quantidade > 0
            ->get()
            ->map(function ($local) {
                return [
                    'id' => $local->id,
                    'descricao' => "{$local->descricao} ({$local->quantidade})" // Concatena nome + quantidade
                ];
            });

        // Verificar se os locais foram encontrados
        if ($locais->isEmpty()) {
            Log::info("Nenhum local encontrado com quantidade disponível para o ativo ID {$ativoId}");
        } else {
            Log::info("Locais encontrados com quantidade disponível para o ativo ID {$ativoId}: " . $locais->count());
        }

        // Retornar os locais formatados
        return response()->json($locais);
    }
}
