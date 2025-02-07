<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Ativo;
use App\Models\AtivoLocal;
use App\Models\Marca;
use App\Models\Tipo;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;


class AtivoController extends Controller
{
    public function index()
    {
        // Carrega os ativos com suas respectivas relações (marca e tipo)
        $ativos = Ativo::with(['marca', 'tipo'])
            ->orderBy('created_at', 'desc')
            ->get();
        $marcas = Marca::all();
        $tipos = Tipo::all();

        return view('ativos.index', compact('ativos', 'marcas', 'tipos'));
    }

    public function create()
    {
        // Para o formulário de cadastro, carregamos as marcas e os tipos
        $marcas = Marca::all();
        $tipos = Tipo::all();

        return view('ativos.create', compact('marcas', 'tipos'));
    }



    public function store(Request $request)
    {
        try {
            // Validação dos dados recebidos
            $request->validate([
                'descricao'  => 'required|string|max:255',
                'quantidade' => 'required|integer|min:1',
                'observacao' => 'nullable|string',
                'id_marca'   => 'nullable|exists:marcas,id',
                'id_tipo'    => 'nullable|exists:tipos,id',
                'nova_marca' => 'nullable|string|max:255',
                'novo_tipo'  => 'nullable|string|max:255',
                'id_local'   => 'nullable|integer',
                'status'     => 'required|integer',
                'imagem'     => 'nullable|image|max:2048',
            ], [
                'imagem.image' => 'O arquivo deve ser uma imagem válida.',
                'imagem.max'   => 'A imagem não pode ter mais de 2MB.',
            ]);

            // Processar imagem se estiver presente
            if ($request->hasFile('imagem')) {
                $imagemAtivo = $request->file('imagem');
                // Registra o nome original e o caminho temporário para debug
                Log::info('Processando upload de imagem', [
                    'original' => $imagemAtivo->getClientOriginalName(),
                    'mimetype' => $imagemAtivo->getMimeType(),
                    'tamanho'  => $imagemAtivo->getSize(),
                ]);

                $imagemAtivo = $imagemAtivo->store('ativos', 'public');
                if (!$imagemAtivo) {
                    throw new Exception('Falha ao salvar a imagem.');
                }
                Log::info('Imagem armazenada com sucesso', ['path' => $imagemAtivo]);
            } else {
                $imagemAtivo = null;
                Log::info('Nenhuma imagem foi enviada.');
            }

            // Criando uma nova marca, se fornecida
            if ($request->filled('nova_marca')) {
                $marca = Marca::create(['descricao' => $request->nova_marca]);
                $id_marca = $marca->id;
            } else {
                $id_marca = $request->id_marca;
            }

            // Criando um novo tipo, se fornecido
            if ($request->filled('novo_tipo')) {
                $tipo = Tipo::create(['descricao' => $request->novo_tipo]);
                $id_tipo = $tipo->id;
            } else {
                $id_tipo = $request->id_tipo;
            }

            // Criar o ativo
            $ativo = Ativo::create([
                'descricao'        => $request->descricao,
                'quantidade_total' => $request->quantidade,
                'quantidade_uso'   => 0,
                'quantidade_disp'  => $request->quantidade,
                'status'           => $request->status,
                'observacao'       => $request->observacao,
                'id_marca'         => $id_marca,
                'id_tipo'          => $id_tipo,
                'id_user'          => $request->user()->id,
                'id_local'         => $request->id_local,
                'imagem'     => $imagemAtivo,
            ]);

            // Registrar na tabela ativo_local
            AtivoLocal::create([
                'id_ativo'  => $ativo->id,
                'id_local'  => $request->id_local,
                'quantidade' => $request->quantidade,
            ]);

            Log::info('Ativo cadastrado com sucesso', ['ativo_id' => $ativo->id]);

            return redirect()->route('ativos.index')->with('success', 'Ativo cadastrado com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro ao cadastrar ativo', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->withErrors(['error' => 'Erro ao cadastrar ativo: ' . $e->getMessage()])->withInput();
        }
    }




    public function getAtivosEdit($id)
    {
        // Buscar o ativo para edição
        $ativo = Ativo::findOrFail($id);
        $marcas = Marca::all();
        $tipos = Tipo::all();

        return response()->json([
            'ativo'  => $ativo,
            'marcas' => $marcas,
            'tipos'  => $tipos,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validação dos dados para atualização
        $request->validate([
            'descricao'         => 'required|string|max:255',
            'quantidade_total'  => 'required|integer|min:1',
            'observacao'        => 'nullable|string',
            'id_marca'          => 'required|exists:marcas,id',
            'id_tipo'           => 'required|exists:tipos,id',
            'status'            => 'required|in:ativo,inativo',
            'id_local'          => 'required|exists:locais,id',
        ]);

        $ativo = Ativo::findOrFail($id);

        // Para atualizar, considere se a quantidade total foi alterada:
        // Se a quantidade total mudar, pode ser necessário recalcular a quantidade disponível
        // Exemplo simples: assumindo que a quantidade de uso permanece a mesma,
        // então a quantidade disponível passa a ser:
        //      nova quantidade_total - quantidade_uso
        $novaQuantidadeTotal = $request->quantidade;
        $quantidadeUso = $ativo->quantidade_uso; // valor atual de uso
        $quantidadeDisponivel = $novaQuantidadeTotal - $quantidadeUso;
        if ($quantidadeDisponivel < 0) {
            // Se o uso exceder a nova quantidade total, lançamos erro
            return redirect()->back()->withErrors(['quantidade' => 'A quantidade total não pode ser menor que a quantidade em uso.']);
        }

        $ativo->update([
            'descricao'        => $request->descricao,
            'quantidade_total' => $novaQuantidadeTotal,
            'quantidade_disp'  => $quantidadeDisponivel,
            'status'           => $request->status,
            'observacao'       => $request->observacao,
            'id_marca'         => $request->id_marca,
            'id_tipo'          => $request->id_tipo,
            'id_local'         => $request->id_local,
        ]);

        return redirect()->route('ativos.index')->with('success', 'Ativo atualizado com sucesso!');
    }



    public function getLocaisDisponiveis($idAtivo): JsonResponse
    {
        // Obtém os locais onde o ativo está disponível
        $locais = AtivoLocal::where('id_ativo', $idAtivo)
            ->join('locais', 'ativo_local.id_local', '=', 'locais.id') // Certifique-se do nome correto
            ->select('locais.id', 'locais.descricao')
            ->get();


        return response()->json($locais);
    }

    public function destroy($id)
    {
        $ativo = Ativo::find($id);

        if (!$ativo) {
            return response()->json(['success' => false, 'message' => 'Ativo não encontrado.'], 404);
        }

        try {
            $ativo->delete();
            return response()->json(['success' => true, 'message' => 'Ativo excluído com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao excluir o ativo.'], 500);
        }
    }
}
