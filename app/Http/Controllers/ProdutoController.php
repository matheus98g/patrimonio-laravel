<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\MercadoLivreService;
use Illuminate\Http\JsonResponse;
use App\Models\Ativo;
use App\Models\AtivoLocal;
use App\Models\Marca;
use App\Models\Tipo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;


class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); 

        $mercadoLivreService = new MercadoLivreService();
        $produtosList = $mercadoLivreService->searchProduto($search);

        return view('produtos.index', compact('produtosList', 'search'));
    }

    public function getProdutoByAtivo($descricao)
    {
        $mercadoLivreService = new MercadoLivreService();
        $produtosList = $mercadoLivreService->searchProduto($descricao);

        return view('produtos.index', compact('produtosList'));
    }
}
