<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Models\AtivoLocal;
use App\Models\Movimentacao;
use App\Models\Local;
use App\Models\Ativo;
use App\Models\User;
use App\Models\LocalAtivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class MovimentacaoController extends Controller
{

    public function index(Request $request)
    {
        $movimentacoes = Movimentacao::with(['ativo', 'user', 'origem', 'destino'])
            ->orderBy('created_at', 'DESC')
            ->paginate(15);

        $locais = Local::all()->keyBy('id');

        $ativos = Ativo::all();

        // Log::info('Locais carregados:', ['locais' => $locais]);
        // Log::info('Ativos carregados:', ['ativos' => $ativos]);

        return view('movimentacoes.index', compact('movimentacoes', 'locais', 'ativos'));
    }

    public function create()
    {
        $ativos = Ativo::all();
        $locais = Local::all()->keyBy('id');

        return view('movimentacoes.create', compact('ativos', 'locais'));
    }



    public function search(Request $request)
    {
        $query = Movimentacao::with(['ativo', 'user', 'origem', 'destino']);

        $locais = Local::all();
        $ativos = Ativo::all();
        $users = User::all();

        Log::info('Locais carregados para filtro:', ['locais' => $locais]);
        Log::info('Ativos carregados para filtro:', ['ativos' => $ativos]);

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('observacao', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('id_user', 'like', "%{$search}%")
                    ->orWhereHas('ativo', function ($subQuery) use ($search) {
                        $subQuery->where('descricao', 'like', "%{$search}%");
                    })
                    ->orWhereHas('origem', function ($subQuery) use ($search) {
                        $subQuery->where('descricao', 'like', "%{$search}%");
                    })
                    ->orWhereHas('destino', function ($subQuery) use ($search) {
                        $subQuery->where('descricao', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('local_origem')) {
            $query->where('local_origem', $request->input('local_origem'));
        }

        if ($request->filled('local_destino')) {
            $query->where('local_destino', $request->input('local_destino'));
        }

        $query->orderBy('created_at', 'desc');

        $movimentacoes = $query->paginate(15)->appends($request->all());

        return view('movimentacoes.index', compact('movimentacoes', 'request', 'ativos', 'locais', 'users'));
    }





    public function store(Request $request)
    {
        Log::info('Dados recebidos do formulário: ', $request->all());

        $validated = $request->validate([
            'id_ativo' => 'required|exists:ativos,id',
            'local_origem' => 'required|exists:locais,id',
            'local_destino' => 'required|exists:locais,id|different:local_origem',
            'quantidade_mov' => 'required|integer|min:1',
            'observacao' => 'nullable|string|max:255',
            'status' => 'nullable|in:concluido,pendente',
        ]);

        $validated['status'] = $validated['status'] ?? 'concluido';

        Log::info('Dados validados com sucesso:', ['validated' => $validated]);

        Log::info('Início do processo de movimentação.', ['request' => $validated]);

        DB::beginTransaction();
        try {
            Log::info('Criando movimentação no banco de dados...');
            $movimentacao = Movimentacao::create([
                'id_ativo' => $validated['id_ativo'],
                'local_origem' => $validated['local_origem'],
                'local_destino' => $validated['local_destino'],
                'quantidade_mov' => $validated['quantidade_mov'],
                'status' => $validated['status'],
                'observacao' => $validated['observacao'],
                'id_user' => $request->user()->id,
            ]);

            Log::info('Movimentação registrada no banco:', ['movimentacao' => $movimentacao]);

            Log::info('Verificando a quantidade no local de origem...');
            $ativoLocalOrigem = AtivoLocal::where('id_ativo', $validated['id_ativo'])
                ->where('id_local', $validated['local_origem'])
                ->first();

            if (!$ativoLocalOrigem) {
                Log::warning('Ativo não encontrado no local de origem.', ['id_local_origem' => $validated['local_origem']]);
                return response()->json(['error' => 'Ativo não encontrado no local de origem.'], 404);
            }

            Log::info('Ativo no local de origem encontrado:', ['ativo_local_origem' => $ativoLocalOrigem]);

            if ($ativoLocalOrigem->quantidade >= $validated['quantidade_mov']) {
                $ativoLocalOrigem->quantidade -= $validated['quantidade_mov'];
                $ativoLocalOrigem->save();

                Log::info('Quantidade subtraída no local de origem.', [
                    'quantidade_subtraida' => $validated['quantidade_mov'],
                    'novo_valor_quantidade' => $ativoLocalOrigem->quantidade
                ]);
            } else {
                Log::warning('Quantidade insuficiente no local de origem.', [
                    'quantidade' => $ativoLocalOrigem->quantidade,
                    'quantidade_requerida' => $validated['quantidade_mov']
                ]);
                return response()->json(['error' => 'Quantidade insuficiente no local de origem.'], 400);
            }

            $this->updateQuantidade($validated['id_ativo'], $validated['quantidade_mov'], $validated['local_destino']);

            DB::commit();
            Log::info('Movimentação processada e transação comitada com sucesso.');

            return redirect()->route('movimentacoes.index')->with('success', 'Movimentação realizada com sucesso!');
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Log::error('Erro na consulta ao banco de dados:', ['error_message' => $e->getMessage()]);
            return response()->json(['error' => 'Erro na consulta ao banco de dados.'], 500);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro desconhecido:', ['error_message' => $e->getMessage()]);
            return response()->json(['error' => 'Erro desconhecido.'], 500);
        }
    }

    private function updateQuantidade($idAtivo, $quantidadeMov, $idLocalDestino)
    {
        Log::info('Atualizando a quantidade no local de destino...');

        $ativoLocalDestino = AtivoLocal::where('id_ativo', $idAtivo)
            ->where('id_local', $idLocalDestino)
            ->first();

        if ($ativoLocalDestino) {
            $ativoLocalDestino->quantidade += $quantidadeMov;
            $ativoLocalDestino->save();

            Log::info('Quantidade no local de destino atualizada.', [
                'id_local_destino' => $idLocalDestino,
                'quantidade_atualizada' => $ativoLocalDestino->quantidade
            ]);
        } else {
            AtivoLocal::create([
                'id_ativo' => $idAtivo,
                'id_local' => $idLocalDestino,
                'quantidade' => $quantidadeMov,
            ]);
            Log::info('Novo registro de quantidade criado no local de destino.', [
                'id_local_destino' => $idLocalDestino,
                'quantidade_adicionada' => $quantidadeMov,
            ]);
        }
    }

    public function showHistorico($id_ativo)
    {
        $movimentacoes = Movimentacao::where('id_ativo', $id_ativo)->get();

        return response()->json(['data' => $movimentacoes]);
    }
}
