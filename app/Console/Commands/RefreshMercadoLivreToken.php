<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Services\MercadoLivreService;

class RefreshMercadoLivreToken extends Command
{
    protected $signature = 'mercado_livre_token:refresh';
    protected $description = 'Renova o token do Mercado Livre';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        \Log::info('Iniciando execução do comando mercado_livre_token:refresh em ' . now());

        $mercadoLivreService = new MercadoLivreService();

        try {
            \Log::debug('Chamando refreshToken() do MercadoLivreService em ' . now());
            // Chama o método refreshToken e verifica o resultado
            $result = $mercadoLivreService->refreshToken();

            // Validação simples: só mostra sucesso se o resultado for verdadeiro ou não nulo
            if ($result) {
                \Log::info('Token renovado com sucesso em ' . now());
                $this->info('Token MercadoLivre renovado com sucesso!');
            } else {
                \Log::warning('Falha ao renovar o token: resultado inválido retornado em ' . now());
                $this->error('Falha ao renovar o token: resultado inválido.');
                return 1; // Indica falha
            }
        } catch (\Exception $e) {
            \Log::error('Erro ao renovar o token em ' . now() . ': ' . $e->getMessage(), [
                'exception' => get_class($e),
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('Erro ao renovar o token: ' . $e->getMessage());
            return 1; // Indica falha
        }

        \Log::info('Comando mercado_livre_token:refresh concluído com sucesso em ' . now());
        return 0; // Sucesso
    }
}
