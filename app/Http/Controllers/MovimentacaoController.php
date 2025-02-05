<?php

namespace App\Http\Controllers;

use App\Models\AtivoLocal;
use App\Models\Movimentacao;
use App\Models\Local;
use App\Models\Ativo;
use App\Models\LocalAtivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class MovimentacaoController extends Controller
{

    public function index()
    {
        $movimentacoes = Movimentacao::with(['ativo', 'user', 'AtivoLocalOrigem', 'AtivoLocalDestino'])->get();
        $locais = Local::all();
        $ativos = Ativo::all();
        return view('movimentacoes.index', compact('movimentacoes', 'ativos', 'locais'));
    }

    /**
     * Registrar uma movimentação de ativo entre locais.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_ativo' => 'required|exists:ativos,id',
            'local_origem' => 'required|exists:locais,id',
            'local_destino'   => 'required|exists:locais,id|different:local_origem',
            'quantidade_mov' => 'required|integer|min:1',
            'observacao' => 'nullable|string|max:255',
            'status' => 'required|in:concluido,pendente',
        ]);

        DB::beginTransaction();

        try {
            // Criar o registro de movimentação com usuário, status e observação
            $movimentacao = Movimentacao::create([
                'id_ativo' => $validated['id_ativo'],
                'local_origem' => $validated['local_origem'],
                'local_destino' => $validated['local_destino'],
                'quantidade_mov' => $validated['quantidade_mov'],
                'status' => $validated['status'],
                'observacao' => $validated['observacao'],
                'id_user' => $request->user()->id, // Captura o usuário autenticado
            ]);

            $ativoLocalOrigem = AtivoLocal::where('id_ativo', $validated['id_ativo'])
                ->where('id_local', $validated['local_origem'])
                ->first();

            $ativoLocalDestino = AtivoLocal::where('id_ativo', $validated['id_ativo'])
                ->where('id_local', $validated['local_destino'])
                ->first();

            if ($ativoLocalOrigem && $ativoLocalOrigem->quantidade >= $validated['quantidade_mov']) {
                $ativoLocalOrigem->quantidade -= $validated['quantidade_mov'];
                $ativoLocalOrigem->save();

                if ($ativoLocalDestino) {
                    $ativoLocalDestino->quantidade += $validated['quantidade_mov'];
                    $ativoLocalDestino->save();
                } else {
                    AtivoLocal::create([
                        'id_ativo' => $validated['id_ativo'],
                        'id_local' => $validated['local_destino'],
                        'quantidade' => $validated['quantidade_mov'],
                    ]);
                }
            } else {
                return response()->json(['error' => 'Quantidade insuficiente no local de origem'], 400);
            }

            DB::commit();

            return response()->json(['message' => 'Movimentação registrada com sucesso', 'data' => $movimentacao]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erro ao processar a movimentação', 'message' => $e->getMessage()], 500);
        }
    }




    /**
     * Exibir o histórico de movimentações de um ativo.
     *
     * @param  int  $id_ativo
     * @return \Illuminate\Http\Response
     */
    public function showHistorico($id_ativo)
    {
        // Consultar todas as movimentações de um ativo
        $movimentacoes = Movimentacao::where('id_ativo', $id_ativo)->get();

        return response()->json(['data' => $movimentacoes]);
    }
}
