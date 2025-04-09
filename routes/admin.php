<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    // Painel principal do Admin
    Route::get('/', [AdminController::class, 'index'])->name('dashboard'); // view: admin.dashboard

    // Usuários
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Roles
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RolePermissionController::class, 'indexRoles'])->name('index');
        Route::get('/create', [RolePermissionController::class, 'createRole'])->name('create');
        Route::post('/', [RolePermissionController::class, 'storeRole'])->name('store');
        Route::get('/{role}/editar', [RolePermissionController::class, 'editRole'])->name('edit');
        Route::put('/{role}', [RolePermissionController::class, 'updateRole'])->name('update');
        Route::delete('/{role}', [RolePermissionController::class, 'destroyRole'])->name('destroy');
    });

    // Permissions
    Route::prefix('permissions')->name('permissions.')->group(function () {
        Route::get('/', [RolePermissionController::class, 'indexPermissions'])->name('index');
        Route::get('/create', [RolePermissionController::class, 'createPermission'])->name('create');
        Route::post('/', [RolePermissionController::class, 'storePermission'])->name('store');
        Route::get('/{permission}', [RolePermissionController::class, 'showPermission'])->name('show');
        Route::get('/{permission}/edit', [RolePermissionController::class, 'editPermission'])->name('edit');
        Route::put('/{permission}', [RolePermissionController::class, 'updatePermission'])->name('update');
        Route::delete('/{permission}', [RolePermissionController::class, 'destroyPermission'])->name('destroy');
    });

});
