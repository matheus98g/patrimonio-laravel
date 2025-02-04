<?php

namespace App\Http\Controllers;

use App\Models\AtivoLocal;
use App\Models\Movimentacao;
use App\Models\Ativo;
use App\Models\Marca;
use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovimentacaoController extends Controller
{

    public function index()
    {
        $movimentacoes = Movimentacao::all();
        $ativos = Ativo::all();
        return view('movimentacoes.index', compact('movimentacoes', 'ativos'));
    }

    /**
     * Registrar uma movimentação de ativo entre locais.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar os dados recebidos
        $validated = $request->validate([
            'id_ativo' => 'required|exists:ativos,id',
            'origem' => 'required|string|max:255',
            'destino' => 'required|string|max:255',
            'quantidade_mov' => 'required|integer|min:1',
        ]);

        // Iniciar transação para garantir integridade dos dados
        DB::beginTransaction();

        try {
            // Criar o registro de movimentação
            $movimentacao = Movimentacao::create([
                'id_ativo' => $validated['id_ativo'],
                'origem' => $validated['origem'],
                'destino' => $validated['destino'],
                'quantidade_mov' => $validated['quantidade_mov'],
                'status' => 1,  // Pode ser um status que você defina, como 'em andamento'
            ]);

            // Lógica de movimentação de ativo (ajustar as quantidades nos locais)
            $ativoLocalOrigem = AtivoLocal::where('id_ativo', $validated['id_ativo'])
                ->where('localizacao', $validated['origem'])
                ->first();

            $ativoLocalDestino = AtivoLocal::where('id_ativo', $validated['id_ativo'])
                ->where('localizacao', $validated['destino'])
                ->first();

            // Verifica se o ativo existe no local de origem e se a quantidade é suficiente
            if ($ativoLocalOrigem && $ativoLocalOrigem->quantidade >= $validated['quantidade_mov']) {
                // Subtrai a quantidade do local de origem
                $ativoLocalOrigem->quantidade -= $validated['quantidade_mov'];
                $ativoLocalOrigem->save();

                // Se o local de destino não existir, cria um novo
                if ($ativoLocalDestino) {
                    // Atualiza a quantidade no destino
                    $ativoLocalDestino->quantidade += $validated['quantidade_mov'];
                    $ativoLocalDestino->save();
                } else {
                    // Cria um novo registro no local de destino
                    AtivoLocal::create([
                        'id_ativo' => $validated['id_ativo'],
                        'localizacao' => $validated['destino'],
                        'quantidade' => $validated['quantidade_mov'],
                    ]);
                }
            } else {
                return response()->json(['error' => 'Quantidade insuficiente no local de origem'], 400);
            }

            // Confirmar transação
            DB::commit();

            return response()->json(['message' => 'Movimentação registrada com sucesso', 'data' => $movimentacao]);
        } catch (\Exception $e) {
            // Reverter transação em caso de erro
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
