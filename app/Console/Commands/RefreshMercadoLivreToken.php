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
        $mercadoLivreService = new MercadoLivreService();
        $mercadoLivreService->refreshToken();
        
        $this->info('Token MercadoLivre renovado com sucesso!');
    }
}
