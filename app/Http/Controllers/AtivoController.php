<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ativo;

class AtivoController extends Controller
{
    public function index()
    {
        // Pegando todos os ativos do banco de dados
        $ativos = Ativo::all();

        // Retornando a view com os dados dos ativos
        return view('ativos.index', compact('ativos'));
    }
}
