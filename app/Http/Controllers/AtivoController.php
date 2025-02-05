<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Ativo;
use App\Models\AtivoLocal;
use App\Models\Marca;
use App\Models\Tipo;

class AtivoController extends Controller
{
    public function index()
    {
        // Carrega os ativos com suas respectivas relações (marca e tipo)
        $ativos = Ativo::with(['marca', 'tipo'])->get();
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
        // Validação dos dados recebidos
        $request->validate([
            'descricao'         => 'required|string|max:255',
            'quantidade_total'  => 'required|integer|min:1',
            'observacao'        => 'nullable|string',
            'id_marca'          => 'nullable|exists:marcas,id',
            'id_tipo'           => 'nullable|exists:tipos,id',
            'nova_marca'        => 'nullable|string|max:255',
            'novo_tipo'         => 'nullable|string|max:255',
            'id_local'          => 'nullable|exists:locais,id',
            'status'            => 'required|in:ativo,inativo',
        ]);

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

        // Se o local não for informado, definir um local padrão (ex: 1)
        $id_local = $request->id_local ?? 1;

        // Criar o ativo
        $ativo = Ativo::create([
            'descricao'        => $request->descricao,
            'quantidade_total' => $request->quantidade_total,
            'quantidade_uso'   => 0,
            'quantidade_disp'  => $request->quantidade_total,
            'status'           => $request->status,
            'observacao'       => $request->observacao,
            'id_marca'         => $id_marca,
            'id_tipo'          => $id_tipo,
            'id_user'          => $request->user()->id,
            'id_local'         => $id_local,
        ]);

        // **Registrar na tabela ativo_local**
        AtivoLocal::create([
            'id_ativo' => $ativo->id,
            'id_local' => $id_local,
            'quantidade' => $request->quantidade_total, // Grava a data atual como a movimentação inicial
        ]);

        return redirect()->route('ativos.index')->with('success', 'Ativo cadastrado com sucesso!');
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
        $novaQuantidadeTotal = $request->quantidade_total;
        $quantidadeUso = $ativo->quantidade_uso; // valor atual de uso
        $quantidadeDisponivel = $novaQuantidadeTotal - $quantidadeUso;
        if ($quantidadeDisponivel < 0) {
            // Se o uso exceder a nova quantidade total, lançamos erro
            return redirect()->back()->withErrors(['quantidade_total' => 'A quantidade total não pode ser menor que a quantidade em uso.']);
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
}
