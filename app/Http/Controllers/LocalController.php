<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Local;
use App\Models\AtivoLocal;
use Illuminate\Http\Request;

class LocalController extends Controller
{
    // public function index()
    // {
    //     // Pegando todos os locais com os dados relacionados de AtivoLocal
    //     $locais = Local::all();

    //     // Retornando a view com os dados dos locais
    //     return view('locais.index', compact('locais'));
    // }

    public function index()
    {
        $locais = DB::table('locais')
            ->leftJoin('ativo_local', 'locais.id', '=', 'ativo_local.id_local')
            ->leftJoin('ativos', 'ativo_local.id_ativo', '=', 'ativos.id')
            ->select(
                'locais.id as id_local',
                'locais.descricao as local_descricao',
                DB::raw('GROUP_CONCAT(CONCAT(ativos.descricao, " (", ativo_local.quantidade, ")") SEPARATOR ", ") as ativos')
            )
            ->whereNotNull('ativo_local.quantidade')
            ->where('ativo_local.quantidade', '>', 0)
            ->groupBy('locais.id', 'locais.descricao')
            ->havingRaw('LENGTH(ativos) > 0') // Garante que só exiba locais com ativos válidos
            ->get();

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
