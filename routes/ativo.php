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
        Route::get('/', [AtivoController::class, 'index'])->middleware('can:view ativos')->name('index');
        Route::get('/{id}', [AtivoController::class, 'show'])->middleware('can:view ativos')->name('show');
        Route::get('/details/{id}', [AtivoController::class, 'showDetails'])->middleware('can:view ativos')->name('show.details');

        Route::post('/', [AtivoController::class, 'store'])->middleware('can:create ativos')->name('store');
        Route::get('/create', [AtivoController::class, 'create'])->middleware('can:create ativos')->name('create');

        Route::put('/{id}', [AtivoController::class, 'update'])->middleware('can:edit ativos')->name('update');
        Route::delete('/{id}', [AtivoController::class, 'destroy'])->middleware('can:delete ativos')->name('destroy');
    });

    Route::prefix('marcas')->name('marcas.')->group(function () {
        Route::get('/', [MarcaController::class, 'index'])->middleware('can:view marcas')->name('index');
        Route::post('/', [MarcaController::class, 'store'])->middleware('can:create marcas')->name('store');
        Route::put('/{id}', [MarcaController::class, 'update'])->middleware('can:edit marcas')->name('update');
        Route::delete('/{id}', [MarcaController::class, 'destroy'])->middleware('can:delete marcas')->name('destroy');
    });

    Route::prefix('tipos')->name('tipos.')->group(function () {
        Route::get('/', [TipoController::class, 'index'])->middleware('can:view tipos')->name('index');
        Route::post('/', [TipoController::class, 'store'])->middleware('can:create tipos')->name('store');
        Route::put('/{id}', [TipoController::class, 'update'])->middleware('can:edit tipos')->name('update');
        Route::delete('/{id}', [TipoController::class, 'destroy'])->middleware('can:delete tipos')->name('destroy');
    });

    Route::prefix('movimentacoes')->name('movimentacoes.')->group(function () {
        Route::get('/', [MovimentacaoController::class, 'index'])->middleware('can:view movimentacoes')->name('index');
        Route::get('/search/{id?}', [MovimentacaoController::class, 'search'])->middleware('can:view movimentacoes')->name('search');
        
        Route::get('/create', [MovimentacaoController::class, 'create'])->middleware('can:create movimentacoes')->name('create');
        Route::post('/', [MovimentacaoController::class, 'store'])->middleware('can:create movimentacoes')->name('store');

        Route::put('/{id}', [MovimentacaoController::class, 'update'])->middleware('can:edit movimentacoes')->name('update');
        Route::delete('/{id}', [MovimentacaoController::class, 'destroy'])->middleware('can:delete movimentacoes')->name('destroy');
    });

    Route::prefix('locais')->name('locais.')->group(function () {
        Route::get('/', [LocalController::class, 'index'])->middleware('can:view locais')->name('index');
        Route::post('/', [LocalController::class, 'store'])->middleware('can:create locais')->name('store');
        Route::put('/{id}', [LocalController::class, 'update'])->middleware('can:edit locais')->name('update');
        Route::delete('/{id}', [LocalController::class, 'destroy'])->middleware('can:delete locais')->name('destroy');
    });

    Route::prefix('produtos')->name('produtos.')->group(function () {
        Route::get('/', [ProdutoController::class, 'index'])->middleware('can:view produtos')->name('index');
        Route::put('/{id}', [ProdutoController::class, 'update'])->middleware('can:edit produtos')->name('update');
    });

});
