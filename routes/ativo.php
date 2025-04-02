<?php

use App\Http\Controllers\AtivoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\MovimentacaoController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('ativos')->name('ativos.')->group(function () {
        Route::get('/', [AtivoController::class, 'index'])->name('index');
        Route::get('/{id}', [AtivoController::class, 'show'])->name('show');
        Route::get('/details/{id}', [AtivoController::class, 'showDetails'])->name('show.details');

        Route::post('/', [AtivoController::class, 'store'])->name('store');
        Route::get('/create', [AtivoController::class, 'create'])->name('create');

        Route::put('/{id}', [AtivoController::class, 'update'])->name('update');
        Route::delete('/{id}', [AtivoController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('marcas')->name('marcas.')->group(function () {
        Route::get('/', [MarcaController::class, 'index'])->name('index');
        Route::post('/', [MarcaController::class, 'store'])->name('store');
        Route::put('/{id}', [MarcaController::class, 'update'])->name('update');
        Route::delete('/{id}', [MarcaController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('tipos')->name('tipos.')->group(function () {
        Route::get('/', [TipoController::class, 'index'])->name('index');
        Route::post('/', [TipoController::class, 'store'])->name('store');
        Route::put('/{id}', [TipoController::class, 'update'])->name('update');
        Route::delete('/{id}', [TipoController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('movimentacoes')->name('movimentacoes.')->group(function () {
        Route::get('/', [MovimentacaoController::class, 'index'])->name('index');
        Route::get('/search/{id?}', [MovimentacaoController::class, 'search'])->name('search');
        
        Route::get('/create', [MovimentacaoController::class, 'create'])->name('create');
        Route::post('/', [MovimentacaoController::class, 'store'])->name('store');

        Route::put('/{id}', [MovimentacaoController::class, 'update'])->name('update');
        Route::delete('/{id}', [MovimentacaoController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('locais')->name('locais.')->group(function () {
        Route::get('/', [LocalController::class, 'index'])->name('index');
        Route::post('/', [LocalController::class, 'store'])->name('store');
        Route::put('/{id}', [LocalController::class, 'update'])->name('update');
        Route::delete('/{id}', [LocalController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('produtos')->name('produtos.')->group(function () {
        Route::get('/', [ProdutoController::class, 'index'])->name('index');
        Route::put('/{id}', [ProdutoController::class, 'update'])->name('update');
    });

});