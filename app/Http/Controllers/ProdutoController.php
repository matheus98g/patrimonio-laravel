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
        $search = $request->input('search'); // Obtém o termo de pesquisa da requisição

        $mercadoLivreService = new MercadoLivreService(); // Instancia o serviço
        $produtosList = $mercadoLivreService->searchProduto($search); // Busca produtos na API

        // Retorna a view passando os produtos e o termo pesquisado
        return view('produtos.index', compact('produtosList', 'search'));
    }
}
