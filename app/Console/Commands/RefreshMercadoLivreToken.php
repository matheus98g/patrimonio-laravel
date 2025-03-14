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
        $mercadoLivreService->refreshToken();
        // \Log::info('Token renovado com sucesso em ' . now());
        // $this->info('Token MercadoLivre renovado com sucesso!');

    }
}