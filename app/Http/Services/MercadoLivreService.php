<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Log;

class MercadoLivreService
{
    public function searchProduto($search)
    {
        $url = "https://api.mercadolibre.com/sites/MLB/search?q=" . urlencode($search);

        try {
            $response = Http::withOptions([
                'verify' => true, // Verifica o certificado SSL
                'curl' => [
                    CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2 // Força o uso do TLS 1.2
                ]
            ])->timeout(10)
                ->retry(3, 500)
                ->get($url);

            if ($response->successful()) {
                return $response->json()['results'] ?? [];
            }

            return ['error' => 'Erro ao buscar produtos: ' . $response->status()];
        } catch (RequestException $e) {
            return ['error' => 'Erro de conexão: ' . $e->getMessage()];
        } catch (\Exception $e) {
            return ['error' => 'Erro inesperado: ' . $e->getMessage()];
        }
    }
}
