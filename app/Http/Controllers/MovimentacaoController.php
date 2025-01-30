<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimentacao;
use App\Models\Ativo;
use App\Models\User;

class MovimentacaoController extends Controller
{
    public function index()
    {
        $movimentacoes = Movimentacao::with(['ativo', 'user'])->get(); // Faz o JOIN automaticamente
        $ativos = Ativo::all(); // Busca todos os ativos
        $users = User::All();

        return view('movimentacoes.index', compact('movimentacoes', 'ativos', 'users')); // Enviando 'ativos' para a view

    }

    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_ativo' => 'required|exists:ativos,id',
            'descricao' => 'required|string|max:255',
            'status' => 'required|string|max:50',
            'origem' => 'nullable|string|max:255',
            'destino' => 'nullable|string|max:255',
            'qntUso' => 'required|integer|min:0',
            'tipo' => 'required|string|max:50',
        ]);

        // Criando a movimentação
        Movimentacao::create([
            'id_user' => $request->id_user,
            'id_ativo' => $request->id_ativo,
            'descricao' => $request->descricao,
            'status' => $request->status,
            'origem' => $request->origem,
            'destino' => $request->destino,
            'qntUso' => $request->qntUso,
            'tipo' => $request->tipo,
        ]);

        return redirect()->route('movimentacoes.index')->with('success', 'Movimentação adicionada com sucesso!');
    }
}
