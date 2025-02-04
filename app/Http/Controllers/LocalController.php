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
        $locais = Local::with('ativosLocais')->get();

        $ativosLocais = AtivoLocal::all();

        // Retornando a view com os dados dos locais
        return view('locais.index', compact('locais', 'ativosLocais'));
    }

    public function store(Request $request)
    {
        // Validando os dados
        $request->validate([
            'descricao' => 'required|string|max:255',
        ]);

        // Criando o novo local
        Local::create([
            'descricao' => $request->descricao,
        ]);

        // Redirecionando de volta para a página de locais
        return redirect()->route('locais.index')->with('success', 'Local criado com sucesso!');
    }
}
