<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipo;

class TipoController extends Controller
{
    public function index()
    {
        // Pegando todos os ativos do banco de dados
        $tipos = Tipo::all();

        // Retornando a view com os dados dos ativos
        return view('tipos.index', compact('tipos'));
    }

    public function store(Request $request)
    {
        // Validando os dados
        $request->validate([
            'descricao' => 'required|string|max:255',
        ]);

        // Criando a nova marca
        Tipo::create([
            'descricao' => $request->descricao,
        ]);

        // Redirecionando de volta para a página de marcas
        return redirect()->route('tipos.index')->with('success', 'Marca criada com sucesso!');
    }
}
