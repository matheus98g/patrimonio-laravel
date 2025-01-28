<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;

class MarcaController extends Controller
{
    public function index()
    {
        // Pegando todos os ativos do banco de dados
        $marcas = Marca::all();

        // Retornando a view com os dados dos ativos
        return view('marcas.index', compact('marcas'));
    }

    public function store(Request $request)
    {
        // Validando os dados
        $request->validate([
            'descricao' => 'required|string|max:255',
        ]);

        // Criando a nova marca
        Marca::create([
            'descricao' => $request->descricao,
        ]);

        // Redirecionando de volta para a página de marcas
        return redirect()->route('marcas.index')->with('success', 'Marca criada com sucesso!');
    }
}
