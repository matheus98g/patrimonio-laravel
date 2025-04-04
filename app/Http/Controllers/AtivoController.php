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

        $query = Ativo::with([
            'marca' => function ($query) {
                $query->select('marca.id', 'marca.descricao');
            },
            'tipo' => function ($query) {
                $query->select('tipo.id', 'tipo.descricao');
            },
            'locais' => function ($query) {
                $query->select('local.id', 'local.descricao');
            },
            'user' => function ($query) {
                $query->select('users.id', 'users.name');
            }
        ])->orderBy('created_at', 'desc');

        $user = auth()->user();
        $userName = $user ? $user->name : 'Usuário não autenticado';

        Log::info('Pesquisa realizada em ativos:', [
            'termo' => $search,
            'user' => $userName
        ]);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('descricao', 'like', "%{$search}%")
                    ->orWhere('observacao', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('quantidade', '=', (int) $search)
                    ->orWhere('quantidade_min', '=', (int) $search)
                    ->orWhere('marca_id', '=', (int) $search)
                    ->orWhere('tipo_id', '=', (int) $search)
                    ->orWhere('user_id', '=', (int) $search)
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
            ->select('ativo_id', DB::raw('SUM(quantidade) AS quantidade_disp'))
            ->where('local_id', '=', 1)
            ->groupBy('ativo_id')
            ->get();

        return view('ativos.index', compact('ativos', 'marcas', 'tipos', 'ativosDisp'));
    }

    public function showDetails($id)
    {
        $ativo = Ativo::with('movimentacoes', 'locais')->findOrFail($id);
        $marcas = Marca::all();
        $tipos = Tipo::all();

        $ativosDisp = DB::table('ativo_local')
            ->select('ativo_id', DB::raw('SUM(quantidade) AS quantidade_disp'))
            ->where('local_id', '=', 1)
            ->groupBy('ativo_id')
            ->get();

        $movimentacoes = $ativo->movimentacoes;
        $locais = $ativo->locais;

        return view('ativos.show', compact('ativo', 'marcas', 'tipos', 'ativosDisp', 'movimentacoes', 'locais'));
    }



    public function show($id)
    {
        $ativo = Ativo::with('movimentacoes', 'locais')->findOrFail($id);
        $marcas = Marca::all();
        $tipos = Tipo::all();

        $ativosDisp = DB::table('ativo_local')
            ->select('ativo_id', DB::raw('SUM(quantidade) AS quantidade_disp'))
            ->where('local_id', '=', 1)
            ->groupBy('ativo_id')
            ->get();

        $movimentacoes = $ativo->movimentacoes;
        $locais = $ativo->locais;

        return view('ativos.show', compact('ativo', 'marcas', 'tipos', 'ativosDisp', 'movimentacoes', 'locais'));
    }

    public function create()
    {
        $ativos = Ativo::all();
        $marcas = Marca::all();
        $tipos = Tipo::all();

        return view('ativos.create', compact('ativos', 'marcas','tipos'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'descricao' => 'required|string|max:255',
                'quantidade' => 'required|integer|min:1',
                'quantidade_min' => 'nullable|integer|min:1',
                'observacao' => 'nullable|string',
                'marca_id' => 'nullable|exists:marca,id',
                'tipo_id' => 'nullable|exists:tipo,id',
                'nova_marca' => 'nullable|string|max:255|exclude_if:marca_id,!=,null',
                'novo_tipo' => 'nullable|string|max:255|exclude_if:tipo_id,!=,null',
                'imagem' => 'nullable|image|max:2048',
            ]);

            $marca_id = $this->processarMarca($request);
            $tipo_id = $this->processarTipo($request);

            try {
                $imagemPath = $this->uploadImagem($request);
            } catch (Exception $e) {
                return redirect()->back()
                    ->withErrors(['imagem' => $e->getMessage()])
                    ->withInput();
            }

            $ativo = Ativo::create([
                'descricao' => $request->descricao,
                'quantidade' => $request->quantidade,
                'quantidade_min' => $request->quantidade_min,
                'status' => 1,
                'observacao' => $request->observacao,
                'marca_id' => $marca_id,
                'tipo_id' => $tipo_id,
                'user_id' => $request->user()->id,
                'imagem' => $imagemPath,
            ]);

            AtivoLocal::create([
                'ativo_id' => $ativo->id,
                'local_id' => $request->local_id,
                'quantidade' => $request->quantidade,
            ]);

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
                'marca_id' => 'required|exists:marcas,id',
                'tipo_id' => 'required|exists:tipos,id',
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
                'marca_id',
                'tipo_id',
                'status',
            ]);

            $dados['quantidade'] = max(0, $request->quantidade);
            $dados['quantidade_min'] = $request->quantidade_min !== null ? max(0, $request->quantidade_min) : null;
            Log::info("Dados extraídos para atualização", ['dados' => $dados]);

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

            Log::info("Atualizando ativo no banco...");
            $ativo->update($dados);
            Log::info("Ativo atualizado com sucesso", ['ativo_atualizado' => $ativo->toArray()]);

            $ativoLocal = AtivoLocal::where('ativo_id', $id)->first();
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

            // $ativo->locais()->delete();

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

    private function processarMarca(Request $request)
    {
        if ($request->filled('nova_marca')) {
            $marca = Marca::firstOrCreate(['descricao' => $request->nova_marca]);
            return $marca->id;
        }
        return $request->marca_id;
    }

    private function processarTipo(Request $request)
    {
        if ($request->filled('novo_tipo')) {
            $tipo = Tipo::firstOrCreate(['descricao' => $request->novo_tipo]);
            return $tipo->id;
        }
        return $request->tipo_id;
    }

    private function uploadImagem(Request $request)
    {
        try {
            if (!$request->hasFile('imagem')) {
                return null;
            }

            $imagem = $request->file('imagem');

            $nomeArquivo = 'ativo-' . uniqid() . '.' . $imagem->getClientOriginalExtension();
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
        // Verifica se o ativo existe
        $ativo = Ativo::find($ativoId);

        // Se o ativo não existir, registra um aviso no log
        if (!$ativo) {
            Log::warning("Ativo não encontrado: ID {$ativoId}");
            return response()->json([], 404); // Retorna uma resposta 404 se o ativo não for encontrado
        }

        // Obtém os locais onde o ativo tem quantidade disponível
        $locais = DB::table('ativo_local')
            ->join('local', 'ativo_local.local_id', '=', 'local.id')
            ->select('local.id', 'local.descricao', 'ativo_local.quantidade')
            ->where('ativo_local.ativo_id', $ativoId)
            ->where('ativo_local.quantidade', '>', 0) // Garante que a quantidade seja maior que 0
            ->get()
            ->map(function ($local) {
                return [
                    'id' => $local->id,
                    'descricao' => "{$local->descricao} ({$local->quantidade})"
                ];
            });

        // Log para verificar se algum local foi encontrado
        if ($locais->isEmpty()) {
            Log::info("Nenhum local encontrado com quantidade disponível para o ativo ID {$ativoId}");
        } else {
            Log::info("Locais encontrados com quantidade disponível para o ativo ID {$ativoId}: " . $locais->count());
        }

        // Retorna os locais como JSON
        return response()->json($locais);
    }



}
