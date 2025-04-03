<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Local;
use App\Models\AtivoLocal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class LocalController extends Controller
{


    public function index()
    {
        $locais = DB::table('local')
            ->leftJoin('ativo_local', 'local.id', '=', 'ativo_local.local_id')
            ->leftJoin('ativo', 'ativo_local.ativo_id', '=', 'ativo.id')
            ->select(
                'local.id as local_id',
                'local.descricao as local_descricao',
                'local.observacao as local_observacao',
                DB::raw('GROUP_CONCAT(CONCAT(ativo.descricao, " (", ativo_local.quantidade, ")") SEPARATOR ", ") as ativo')
            )
            ->groupBy('local.id', 'local.descricao')
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

    public function destroy($id)
    {
        try {
            $local = Local::findOrFail($id);

            $local->delete();

            Log::info('Local excluido com sucesso.');

            return response()->json([
                'success' => true,
                'message' => 'Local excluído com sucesso!'
            ]);
        } catch (Exception $e) {
            Log::error('Erro ao excluir local: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir local!'
            ], 500);
        }
    }
}
