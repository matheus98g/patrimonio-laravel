<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AtivoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\MovimentacaoController;
use App\Http\Controllers\LocalController;


// Dashboard (Página inicial autenticada)
Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grupo de rotas protegidas por autenticação
Route::middleware('auth')->group(function () {

    // Ativos
    Route::prefix('ativos')->name('ativos.')->group(function () {
        Route::get('/', [AtivoController::class, 'index'])->name('index');
        Route::post('/store', [AtivoController::class, 'store'])->name('store');
        Route::put('/{ativo}', [AtivoController::class, 'update'])->name('update'); //editar
    });
    Route::get('/{id}/locais-disponiveis', [AtivoController::class, 'getLocaisDisponiveis']);


    // Marcas
    Route::prefix('marcas')->name('marcas.')->group(function () {
        Route::get('/', [MarcaController::class, 'index'])->name('index');
        Route::post('/store', [MarcaController::class, 'store'])->name('store');
        Route::put('/update', [MarcaController::class, 'update'])->name('update');
        Route::delete('/delete', [MarcaController::class, 'destroy'])->name('delete');
    });

    // Tipos
    Route::prefix('tipos')->name('tipos.')->group(function () {
        Route::get('/', [TipoController::class, 'index'])->name('index');
        Route::post('/store', [TipoController::class, 'store'])->name('store');
        Route::put('/update', [TipoController::class, 'update'])->name('update');
        Route::delete('/delete', [TipoController::class, 'destroy'])->name('delete');
    });

    // Movimentações
    Route::prefix('movimentacoes')->name('movimentacoes.')->group(function () {
        Route::get('/', [MovimentacaoController::class, 'index'])->name('index');
        Route::post('/store', [MovimentacaoController::class, 'store'])->name('store');
        Route::put('/update', [MovimentacaoController::class, 'update'])->name('update');
        Route::delete('/delete', [MovimentacaoController::class, 'destroy'])->name('delete');
    });

    // Locais
    Route::prefix('locais')->name('locais.')->group(function () {
        Route::get('/', [LocalController::class, 'index'])->name('index');
        Route::post('/store', [LocalController::class, 'store'])->name('store');
        Route::put('/update', [LocalController::class, 'update'])->name('update');
        Route::delete('/delete', [LocalController::class, 'destroy'])->name('delete');
    });

    // Perfil do usuário
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

// Importa as rotas de autenticação padrão do Laravel
require __DIR__ . '/auth.php';
