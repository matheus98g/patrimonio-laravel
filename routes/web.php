<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AtivoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\MovimentacaoController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/', function () {return view('dashboard');})->name('dashboard');

    Route::prefix('ativos')->name('ativos.')->group(function () {
        Route::get('/', [AtivoController::class, 'index'])->name('index')->middleware(['role:admin|permission:view-ativos']);
        Route::get('/details/{id}', [AtivoController::class, 'showDetails'])->name('show.details')->middleware(['role:admin|permission:view-ativos']);
        Route::get('/{id}', [AtivoController::class, 'show'])->name('show')->middleware(['role:admin|permission:view-ativos']);
        Route::get('/{ativoId}/locais-disponiveis', [AtivoController::class, 'getLocaisDisponiveis'])->name('locais')->middleware(['role:admin|permission:view-ativos']);
        Route::middleware(['role:admin|permission:create-ativos'])->group(function () {
            Route::post('/', [AtivoController::class, 'store'])->name('store');
        });
        Route::middleware(['role:admin|permission:edit-ativos'])->group(function () {
            Route::put('/{id}', [AtivoController::class, 'update'])->name('update');
        });
        Route::middleware(['role:admin|permission:delete-ativos'])->group(function () {
            Route::delete('/{id}', [AtivoController::class, 'destroy'])->name('destroy');
        });
    });



    Route::prefix('marcas')->name('marcas.')->group(function () {
        Route::get('/', [MarcaController::class, 'index'])->name('index');
        Route::post('/store', [MarcaController::class, 'store'])->name('store');
        Route::put('/', [MarcaController::class, 'update'])->name('update');
        Route::delete('/', [MarcaController::class, 'destroy'])->name('delete');
    });

    Route::prefix('tipos')->name('tipos.')->group(function () {
        Route::get('/', [TipoController::class, 'index'])->name('index');
        Route::post('/store', [TipoController::class, 'store'])->name('store');
        Route::put('/', [TipoController::class, 'update'])->name('update');
        Route::delete('/', [TipoController::class, 'destroy'])->name('delete');
    });

    Route::prefix('movimentacoes')->name('movimentacoes.')->group(function () {
        Route::get('/', [MovimentacaoController::class, 'index'])->name('index');
        Route::post('/search', [MovimentacaoController::class, 'search'])->name('search');
        Route::post('/store', [MovimentacaoController::class, 'store'])->name('store');
        Route::put('/', [MovimentacaoController::class, 'update'])->name('update');
        Route::delete('/', [MovimentacaoController::class, 'destroy'])->name('delete');
    });

    Route::prefix('locais')->name('locais.')->group(function () {
        Route::get('/', [LocalController::class, 'index'])->name('index');
        Route::post('/store', [LocalController::class, 'store'])->name('store');
        Route::put('/', [LocalController::class, 'update'])->name('update');
        Route::delete('/{id}', [LocalController::class, 'destroy'])->name('delete');
    });

    Route::prefix('produtos')->name('produtos.')->group(function () {
        Route::get('/', [ProdutoController::class, 'index'])->name('index');
        Route::patch('/', [ProdutoController::class, 'update'])->name('update');
        Route::delete('/', [ProdutoController::class, 'destroy'])->name('destroy');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware(['password.confirm']);
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    //     Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    //     Route::prefix('roles')->name('roles.')->group(function () {
    //         Route::get('/', [RoleController::class, 'index'])->name('index');
    //         Route::get('{roleId}', [RoleController::class, 'show'])->name('show');
    //         Route::post('create', [RoleController::class, 'store'])->name('create');
    //         Route::put('{roleId}', [RoleController::class, 'update'])->name('update');
    //         Route::delete('{roleId}', [RoleController::class, 'destroy'])->name('destroy');

    //         Route::prefix('{roleId}/permissions')->name('permissions.')->group(function () {
    //             Route::post('/', [RolePermissionController::class, 'assignPermission'])->name('assign');
    //             Route::delete('/', [RolePermissionController::class, 'removePermission'])->name('remove');
    //         });
    //     });

    //     Route::prefix('permissions')->name('permissions.')->group(function () {
    //         Route::get('/', [PermissionController::class, 'index'])->name('index');
    //         Route::get('{permissionId}', [PermissionController::class, 'show'])->name('show');
    //         Route::post('create', [PermissionController::class, 'store'])->name('create');
    //         Route::put('{permissionId}', [PermissionController::class, 'update'])->name('update');
    //         Route::delete('{permissionId}', [PermissionController::class, 'destroy'])->name('destroy');
    //     });

    // });

});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
