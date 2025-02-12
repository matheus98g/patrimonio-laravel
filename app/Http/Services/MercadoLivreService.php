<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class MercadoLivreService
{
    public function searchProduto($search)
    {
        $response = Http::get('https://api.mercadolibre.com/sites/MLB/search?q=' . $search);

        $produtos = $response->json();

        return $produtos;
    }
}
