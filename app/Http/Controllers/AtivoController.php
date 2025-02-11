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
                'quantidade_total' => 'required|integer|min:1',
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
                'quantidade_total' => $request->quantidade_total,
                'quantidade_disp' => $request->quantidade_total,
                'status' => 1, // Ativo por padrão
                'observacao' => $request->observacao,
                'id_marca' => $id_marca,
                'id_tipo' => $id_tipo,
                'id_user' => $request->user()->id,
                'imagem' => $imagemPath,
            ]);

            AtivoLocal::create([
                'id_ativo' => $ativo->id,
                'id_local' => $request->id_local, // local padrao: 1 (almoxarifado)
                'quantidade' => $request->quantidade_total, // Atribui a quantidade total ao local fixo
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
                'quantidade_total' => 'required|integer|min:1',
                'observacao' => 'nullable|string',
                'id_marca' => 'required|exists:marcas,id',
                'id_tipo' => 'required|exists:tipos,id',
                'status' => 'required|boolean',
                // 'id_local' => 'required|exists:locais,id',
                'imagem' => 'nullable|image|max:2048',
            ]);

            $ativo = Ativo::findOrFail($id);
            $dados = $request->only([
                'descricao',
                'quantidade_total',
                'observacao',
                'id_marca',
                'id_tipo',
                'status',
                // 'id_local'
            ]);

            // Atualizar quantidades
            $dados['quantidade_disp'] = max(
                0,
                $request->quantidade_total - $ativo->quantidade_uso
            );

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

            // // Atualizar localização
            // AtivoLocal::updateOrCreate(
            //     ['id_ativo' => $ativo->id],
            //     ['id_local' => $request->id_local, 'quantidade' => $request->quantidade_total]
            // );

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
            $ativo->locais()->delete();

            // Deletar imagem
            $this->deletarImagemAntiga($ativo->imagem);

            $ativo->delete();

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
}
