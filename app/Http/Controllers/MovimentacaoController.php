<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimentacao;

class MovimentacaoController extends Controller
{
    public function index()
    {
        $movimentacoes = Movimentacao::with(['user', 'ativo'])->get(); // Carregando os dados com as relações

        return view('movimentacoes.index', compact('movimentacoes'));
    }
}
