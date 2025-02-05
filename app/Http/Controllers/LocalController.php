<?php

namespace App\Http\Controllers;

use App\Models\Local;
use App\Models\AtivoLocal;
use Illuminate\Http\Request;

class LocalController extends Controller
{
    public function index()
    {
        // Pegando todos os locais com os dados relacionados de AtivoLocal
        $locais = Local::all();

        // Retornando a view com os dados dos locais
        return view('locais.index', compact('locais'));
    }


    public function store(Request $request)
    {
        // Validação dos dados, incluindo o campo observacao como opcional
        $request->validate([
            'descricao'   => 'required|string|max:255',
            'observacao'  => 'nullable|string',
        ]);

        // Criação do novo local, incluindo observacao
        Local::create([
            'descricao'  => $request->descricao,
            'observacao' => $request->observacao,
        ]);

        // Redirecionando de volta para a página de locais
        return redirect()->route('locais.index')->with('success', 'Local criado com sucesso!');
    }
}
