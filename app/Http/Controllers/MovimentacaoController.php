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
        // Paginação com as relações necessárias, incluindo ativo_local
        $movimentacoes = Movimentacao::with(['ativo', 'user', 'ativoLocalOrigem', 'ativoLocalDestino'])
            ->orderBy('created_at', 'DESC')
            ->paginate(15);

        // Consultar todos os locais (tabela 'local')
        $locais = Local::all()->keyBy('id'); // Indexando pelos 'id' para fácil acesso

        // Consultar todos os ativos
        $ativos = Ativo::all();

        // Verifique se os dados estão sendo carregados corretamente
        Log::info('Locais carregados:', ['locais' => $locais]);
        Log::info('Ativos carregados:', ['ativos' => $ativos]);

        // Retornar a view com as variáveis necessárias
        return view('movimentacoes.index', compact('movimentacoes', 'ativos', 'locais'));
    }



    public function search(Request $request)
    {
        // Inicia a query utilizando Eloquent
        $query = Movimentacao::with(['ativo', 'user', 'ativoLocalOrigem', 'ativoLocalDestino']);
        $locais = Local::all();
        $ativos = Ativo::all();
        $users = User::all();

        // Se houver um parâmetro 'search' na requisição, aplica os filtros
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('observacao', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('quantidade_mov', 'like', "%{$search}%")
                    ->orWhere('id_user', 'like', "%{$search}%")
                    ->orWhereHas('ativo', function ($subQuery) use ($search) {
                        $subQuery->where('descricao', 'like', "%{$search}%");
                    });
            });
        }

        // Pagina os resultados e mantém os filtros aplicados
        $movimentacoes = $query->paginate(15)->appends($request->all());

        return view('movimentacoes.index', compact('movimentacoes', 'request', 'ativos', 'locais', 'users'));
    }

    public function store(Request $request)
    {
        // Log dos dados recebidos do formulário
        Log::info('Dados recebidos do formulário: ', $request->all());

        // Validação dos dados recebidos
        $validated = $request->validate([
            'id_ativo' => 'required|exists:ativos,id',
            'local_origem' => 'required|exists:locais,id',
            'local_destino' => 'required|exists:locais,id|different:local_origem',
            'quantidade_mov' => 'required|integer|min:1',
            'observacao' => 'nullable|string|max:255',
            'status' => 'nullable|in:concluido,pendente', // O status pode ser opcional se não for fornecido diretamente
        ]);

        // Se o status não for enviado, atribui o valor 'concluido'
        $validated['status'] = $validated['status'] ?? 'concluido';

        // Log após validação
        Log::info('Dados validados com sucesso:', ['validated' => $validated]);

        // Início do processo de movimentação
        Log::info('Início do processo de movimentação.', ['request' => $validated]);

        DB::beginTransaction();
        try {
            // Criar o registro de movimentação com usuário, status e observação
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

            // Verificar a quantidade no local de origem
            Log::info('Verificando a quantidade no local de origem...');
            $ativoLocalOrigem = AtivoLocal::where('id_ativo', $validated['id_ativo'])
                ->where('id_local', $validated['local_origem'])
                ->first();

            // Log do resultado da consulta do local de origem
            if (!$ativoLocalOrigem) {
                Log::warning('Ativo não encontrado no local de origem.', ['id_local_origem' => $validated['local_origem']]);
                return response()->json(['error' => 'Ativo não encontrado no local de origem.'], 404);
            }

            Log::info('Ativo no local de origem encontrado:', ['ativo_local_origem' => $ativoLocalOrigem]);

            // Verificar se o local de origem tem a quantidade suficiente
            if ($ativoLocalOrigem->quantidade >= $validated['quantidade_mov']) {
                // Subtrair a quantidade do local de origem
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

            // Atualizar a quantidade no local de destino
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
        // Verifica e atualiza a quantidade no local de destino
        Log::info('Atualizando a quantidade no local de destino...');

        $ativoLocalDestino = AtivoLocal::where('id_ativo', $idAtivo)
            ->where('id_local', $idLocalDestino)
            ->first();

        if ($ativoLocalDestino) {
            // Se o ativo já existe no local de destino, apenas adiciona a quantidade
            $ativoLocalDestino->quantidade += $quantidadeMov;
            $ativoLocalDestino->save();

            Log::info('Quantidade no local de destino atualizada.', [
                'id_local_destino' => $idLocalDestino,
                'quantidade_atualizada' => $ativoLocalDestino->quantidade
            ]);
        } else {
            // Se o ativo não existe no destino, cria um novo registro
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
        // Consultar todas as movimentações de um ativo
        $movimentacoes = Movimentacao::where('id_ativo', $id_ativo)->get();

        return response()->json(['data' => $movimentacoes]);
    }
}
