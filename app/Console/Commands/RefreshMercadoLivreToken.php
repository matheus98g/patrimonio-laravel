<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Services\MercadoLivreService;

class RefreshMercadoLivreToken extends Command
{
    protected $signature = 'mercado_livre_token:refresh'; // Nome do comando para rodar no cron
    protected $description = 'Renova o token do Mercado Livre'; // Descrição do comando

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Chama o método renovarToken
        $mercadoLivreService = new MercadoLivreService();
        $mercadoLivreService->refreshToken();
        
        $this->info('Token renovado com sucesso!');
    }
}
