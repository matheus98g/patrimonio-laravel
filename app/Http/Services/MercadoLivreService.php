<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Log;
use App\Models\Integracao;

class MercadoLivreService
{

    public function getAccessToken(){

        $integracao = Integracao::where('descricao', '=', 'mercadolivre')->first();
        $accessToken = $integracao->access_token;

        return $accessToken;
    }

    public function searchProduto($search)
        {
            $accessToken = $this->getAccessToken();
            $url = "https://api.mercadolibre.com/sites/MLB/search?" . http_build_query(['q' => $search]);

            try {
                $response = Http::withToken($accessToken)->acceptJson()->get($url);

                if ($response->ok()) {
                    return $response->json()['results'] ?? [];
                }

                Log::error('Erro ao buscar produtos', [
                    'status' => $response->status(),
                    'url' => $url,
                    'search' => $search
                ]);
                
                return ['error' => 'Erro ao buscar produtos', 'status' => $response->status()];
            } catch (RequestException $e) {
                Log::error('Erro de conexão ao buscar produtos', [
                    'message' => $e->getMessage(),
                    'url' => $url,
                    'search' => $search
                ]);

                return ['error' => 'Erro de conexão', 'message' => $e->getMessage()];
            } catch (\Exception $e) {
                Log::error('Erro inesperado ao buscar produtos', [
                    'message' => $e->getMessage(),
                    'url' => $url,
                    'search' => $search
                ]);

                return ['error' => 'Erro inesperado', 'message' => $e->getMessage()];
            }
        }


    
    public function refreshToken()
        {
            try {
                $clientId = env('ML_APP_ID');
                $clientSecret = env('ML_SECRET_KEY');

                $integracao = Integracao::where('descricao', '=', 'mercadolivre')->first();
                $refreshToken = $integracao->refresh_token;

                $response = Http::asForm()->post('https://api.mercadolibre.com/oauth/token', [
                    'grant_type' => 'refresh_token',
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'refresh_token' => $refreshToken,
                ]);

                if ($response->successful()) {
                    $data = $response->json();

                    $newAccessToken = $data['access_token'];
                    $newRefreshToken = $data['refresh_token'];

                    $integracao->update([
                        'access_token' => $newAccessToken,
                        'refresh_token' => $newRefreshToken,
                    ]);

                    Log::info('Token MercadoLivre atualizado com sucesso.');
                } else {
                    Log::error('Falha ao renovar o token', [
                        'status' => $response->status(),
                        'response_body' => $response->body(),
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Erro ao renovar o token', [
                    'message' => $e->getMessage(),
                    'exception' => $e,
                ]);

                return response()->json([
                    'error' => 'Erro ao renovar o token',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }

}
