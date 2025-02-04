<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ativo;
use App\Models\Marca;
use App\Models\Tipo;

class AtivoController extends Controller
{
    public function index()
    {
        // Pegando todos os ativos do banco de dados
        $ativos = Ativo::with(['marca', 'tipo'])->get();
        $marcas = Marca::all(); // Pegando todas as marcas
        $tipos = Tipo::all();   // Pegando todos os tipos

        // Retornando a view com os dados dos ativos, marcas e tipos
        return view('ativos.index', compact('ativos', 'marcas', 'tipos'));
    }

    public function create()
    {
        // Pegando todas as marcas e tipos para o formulário
        $marcas = Marca::all();
        $tipos = Tipo::all();

        return view('ativos.index', compact('marcas', 'tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'id_marca' => 'nullable|exists:marcas,id',
            'id_tipo' => 'nullable|exists:tipos,id',
            'quantidade' => 'required|integer|min:1',
            'observacao' => 'nullable|string',
            'nova_marca' => 'nullable|string|max:255',
            'novo_tipo' => 'nullable|string|max:255',
            'local_id' => 'nullable|exists:locais,id', // Validação do local
        ]);

        // Lógica para adicionar uma nova marca, se fornecida
        if ($request->nova_marca) {
            $marca = Marca::create(['descricao' => $request->nova_marca]);
            $id_marca = $marca->id;
        } else {
            $id_marca = $request->id_marca;
        }

        // Lógica para adicionar um novo tipo, se fornecido
        if ($request->novo_tipo) {
            $tipo = Tipo::create(['descricao' => $request->novo_tipo]);
            $id_tipo = $tipo->id;
        } else {
            $id_tipo = $request->id_tipo;
        }

        // Definir local_id padrão se não for enviado na requisição
        $local_id = 1;

        // Criação do ativo
        Ativo::create([
            'descricao' => $request->descricao,
            'id_marca' => $id_marca,
            'id_tipo' => $id_tipo,
            'quantidade' => $request->quantidade,
            'observacao' => $request->observacao,
            'id_user' => $request->user()->id,
            'local_id' => $local_id
        ]);

        return redirect()->route('ativos.index')->with('success', 'Ativo cadastrado com sucesso!');
    }



    public function getAtivosEdit($id)
    {
        // Buscar o ativo para editar
        $ativo = Ativo::findOrFail($id);
        $marcas = Marca::all(); // Pegando todas as marcas
        $tipos = Tipo::all();   // Pegando todos os tipos

        return response()->json([
            'ativo' => $ativo,
            'marcas' => $marcas,
            'tipos' => $tipos,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validação dos dados
        $request->validate([
            'descricao' => 'required|string|max:255',
            'id_marca' => 'required|exists:marcas,id',
            'id_tipo' => 'required|exists:tipos,id',
            'quantidade' => 'required|integer|min:1',
            'observacao' => 'nullable|string',
        ]);

        $ativo = Ativo::findOrFail($id);

        // Atualizando os dados
        $ativo->update([
            'descricao' => $request->descricao,
            'id_marca' => $request->id_marca,
            'id_tipo' => $request->id_tipo,
            'quantidade' => $request->quantidade,
            'observacao' => $request->observacao,
        ]);

        return redirect()->route('ativos.index')->with('success', 'Ativo atualizado com sucesso!');
    }
}
