<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Local;
use App\Models\AtivoLocal;
use Illuminate\Http\Request;

class LocalController extends Controller
{


    public function index()
    {
        $locais = DB::table('locais')
            ->leftJoin('ativo_local', 'locais.id', '=', 'ativo_local.id_local')
            ->leftJoin('ativos', 'ativo_local.id_ativo', '=', 'ativos.id')
            ->select(
                'locais.id as id_local',
                'locais.descricao as local_descricao',
                'locais.observacao as local_observacao',
                DB::raw('GROUP_CONCAT(CONCAT(ativos.descricao, " (", ativo_local.quantidade, ")") SEPARATOR ", ") as ativos')
            )
            ->groupBy('locais.id', 'locais.descricao')
            ->get();

        return view('locais.index', compact('locais'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'descricao' => 'required|string|max:255',
            'observacao' => 'nullable|string',
        ]);

        Local::create([
            'descricao' => $request->descricao,
            'observacao' => $request->observacao,
        ]);

        return redirect()->route('locais.index')->with('success', 'Local criado com sucesso!');
    }
}
