<?php

use App\Http\Controllers\AtivoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\MovimentacaoController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rotas de Ativos
    Route::prefix('ativos')->name('ativos.')->group(function () {
        Route::get('/{ativoId}/locais-disponiveis', [AtivoController::class, 'getLocaisDisponiveis'])->name('locais');

        // Rotas de visualização
        Route::middleware(['role_or_permission:admin|view ativos'])->group(function () {
            Route::get('/', [AtivoController::class, 'index'])->name('index');
            Route::get('/details/{id}', [AtivoController::class, 'showDetails'])->name('show.details');
            Route::get('/{id}', [AtivoController::class, 'show'])->name('show');
        });

        // Rotas de CRUD
        Route::middleware(['role_or_permission:admin|create ativos'])->group(function () {
            Route::post('/', [AtivoController::class, 'store'])->name('store');
        });

        Route::middleware(['role_or_permission:admin|edit ativos'])->group(function () {
            Route::put('/{id}', [AtivoController::class, 'update'])->name('update');
        });

        Route::middleware(['role_or_permission:admin|delete ativos'])->group(function () {
            Route::delete('/{id}', [AtivoController::class, 'destroy'])->name('destroy');
        });
    });

    // Rotas de Marcas
    Route::prefix('marcas')->name('marcas.')->group(function () {
        Route::middleware(['role_or_permission:admin|view marcas'])->group(function () {
            Route::get('/', [MarcaController::class, 'index'])->name('index');
        });

        // Rotas de CRUD para Marcas
        Route::middleware(['role_or_permission:admin|create marcas'])->group(function () {
            Route::post('/store', [MarcaController::class, 'store'])->name('store');
        });

        Route::middleware(['role_or_permission:admin|edit marcas'])->group(function () {
            Route::put('/{id}', [MarcaController::class, 'update'])->name('update');
        });

        Route::middleware(['role_or_permission:admin|delete marcas'])->group(function () {
            Route::delete('/{id}', [MarcaController::class, 'destroy'])->name('delete');
        });
    });

    // Rotas de Tipos
    Route::prefix('tipos')->name('tipos.')->group(function () {
        Route::middleware(['role_or_permission:admin|view tipos'])->group(function () {
            Route::get('/', [TipoController::class, 'index'])->name('index');
        });

        // Rotas de CRUD para Tipos
        Route::middleware(['role_or_permission:admin|create tipos'])->group(function () {
            Route::post('/store', [TipoController::class, 'store'])->name('store');
        });

        Route::middleware(['role_or_permission:admin|edit tipos'])->group(function () {
            Route::put('/{id}', [TipoController::class, 'update'])->name('update');
        });

        Route::middleware(['role_or_permission:admin|delete tipos'])->group(function () {
            Route::delete('/{id}', [TipoController::class, 'destroy'])->name('delete');
        });
    });

    // Rotas de Movimentações
    Route::prefix('movimentacoes')->name('movimentacoes.')->group(function () {
        Route::middleware(['role_or_permission:admin|view movimentacoes'])->group(function () {
            Route::get('/', [MovimentacaoController::class, 'index'])->name('index');
            Route::get('/search', [MovimentacaoController::class, 'search'])->name('search');
        });

        // Rotas de CRUD para Movimentações
        Route::middleware(['role_or_permission:admin|create movimentacoes'])->group(function () {
            Route::get('/movimentar-ativo', [MovimentacaoController::class, 'create'])->name('create');
            Route::post('/store', [MovimentacaoController::class, 'store'])->name('store');
        });

        Route::middleware(['role_or_permission:admin|edit movimentacoes'])->group(function () {
            Route::put('/{id}', [MovimentacaoController::class, 'update'])->name('update');
        });

        Route::middleware(['role_or_permission:admin|delete movimentacoes'])->group(function () {
            Route::delete('/{id}', [MovimentacaoController::class, 'destroy'])->name('delete');
        });
    });

    // Rotas de Locais
    Route::prefix('locais')->name('locais.')->group(function () {
        Route::middleware(['role_or_permission:admin|view locais'])->group(function () {
            Route::get('/', [LocalController::class, 'index'])->name('index');
        });

        // Rotas de CRUD para Locais
        Route::middleware(['role_or_permission:admin|create locais'])->group(function () {
            Route::post('/store', [LocalController::class, 'store'])->name('store');
        });

        Route::middleware(['role_or_permission:admin|edit locais'])->group(function () {
            Route::put('/{id}', [LocalController::class, 'update'])->name('update');
        });

        Route::middleware(['role_or_permission:admin|delete locais'])->group(function () {
            Route::delete('/{id}', [LocalController::class, 'destroy'])->name('delete');
        });
    });

    // Rotas de Produtos
    Route::prefix('produtos')->name('produtos.')->group(function () {
        Route::middleware(['role_or_permission:admin|view produtos'])->group(function () {
            Route::get('/', [ProdutoController::class, 'index'])->name('index');
        });

        // Rotas de CRUD para Produtos
        Route::middleware(['role_or_permission:admin|edit produtos'])->group(function () {
            Route::put('/{id}', [ProdutoController::class, 'update'])->name('update');
        });

        Route::middleware(['role_or_permission:admin|delete produtos'])->group(function () {
            Route::delete('/{id}', [ProdutoController::class, 'destroy'])->name('destroy');
        });
    });

});
