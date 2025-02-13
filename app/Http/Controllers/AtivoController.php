<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Ativo;
use App\Models\AtivoLocal;
use App\Models\Marca;
use App\Models\Tipo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;

class AtivoController extends Controller
{
    public function index()
    {
        // No método index
        $ativos = Ativo::with(['marca', 'tipo', 'local', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        $marcas = Marca::all();
        $tipos = Tipo::all();

        return view('ativos.index', compact('ativos', 'marcas', 'tipos'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'descricao' => 'required|string|max:255',
                'quantidade' => 'required|integer|min:1',
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
                'quantidade' => $request->quantidade, // Usando apenas a quantidade
                'status' => 1, // Ativo por padrão
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
            $request->validate([
                'descricao' => 'required|string|max:255',
                'quantidade' => 'required|integer|min:1',
                'observacao' => 'nullable|string',
                'id_marca' => 'required|exists:marcas,id',
                'id_tipo' => 'required|exists:tipos,id',
                'status' => 'required|boolean',
                'imagem' => 'nullable|image|max:2048',
            ]);

            $ativo = Ativo::findOrFail($id);
            $dados = $request->only([
                'descricao',
                'quantidade', // Atualizando apenas a quantidade
                'observacao',
                'id_marca',
                'id_tipo',
                'status',
            ]);

            // Atualizar a quantidade
            $dados['quantidade'] = max(0, $request->quantidade);

            // Fluxo seguro para substituição de imagem
            if ($request->hasFile('imagem')) {
                try {
                    $novaImagem = $this->uploadImagem($request);
                    $this->deletarImagemAntiga($ativo->imagem);
                    $dados['imagem'] = $novaImagem;
                } catch (Exception $e) {
                    return redirect()->back()
                        ->withErrors(['imagem' => $e->getMessage()])
                        ->withInput();
                }
            }

            $ativo->update($dados);

            // Atualizar o vínculo do ativo no local
            $ativoLocal = AtivoLocal::where('id_ativo', $id)->first();
            if ($ativoLocal) {
                $ativoLocal->quantidade = $request->quantidade; // Atualiza a quantidade no local
                $ativoLocal->save();
            }

            return redirect()->route('ativos.index')
                ->with('success', 'Ativo atualizado com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro ao atualizar ativo: ' . $e->getMessage());
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
