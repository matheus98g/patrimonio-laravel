<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Services\MercadoLivreService;

class RefreshMercadoLivreToken extends Command
{
    /**
     * O nome e a assinatura do comando.
     *
     * @var string
     */
    protected $signature = 'mercado_livre_token:refresh';

    /**
     * A descrição do comando.
     *
     * @var string
     */
    protected $description = 'Renova o token do Mercado Livre';

    /**
     * O serviço MercadoLivreService.
     *
     * @var MercadoLivreService
     */
    protected $mercadoLivreService;

    /**
     * Cria uma nova instância de comando.
     *
     * @param  MercadoLivreService  $mercadoLivreService
     * @return void
     */
    public function __construct(MercadoLivreService $mercadoLivreService)
    {
        parent::__construct();
        $this->mercadoLivreService = $mercadoLivreService;
    }

    /**
     * Executa o comando.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->mercadoLivreService->refreshToken();

            Log::info('Token renovado com sucesso', [
                'timestamp' => now(),
            ]);

            $this->info('Token Mercado Livre renovado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao renovar o token do Mercado Livre', [
                'error' => $e->getMessage(),
                'timestamp' => now(),
            ]);
            $this->error('Falha ao renovar o token do Mercado Livre.');
        }
    }
}
