<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('{roleId}', [RoleController::class, 'show'])->name('show');
        Route::post('create', [RoleController::class, 'store'])->name('create');
        Route::put('{roleId}', [RoleController::class, 'update'])->name('update');
        Route::delete('{roleId}', [RoleController::class, 'destroy'])->name('destroy');

        Route::prefix('{roleId}/permissions')->name('permissions.')->group(function () {
            Route::post('/', [RolePermissionController::class, 'assignPermission'])->name('assign');
            Route::delete('/', [RolePermissionController::class, 'removePermission'])->name('remove');
        });
    });

    Route::prefix('permissions')->name('permissions.')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index');
        Route::get('{permissionId}', [PermissionController::class, 'show'])->name('show');
        Route::post('create', [PermissionController::class, 'store'])->name('create');
        Route::get('{permissionId}/edit', [PermissionController::class, 'edit'])->name('edit');
        Route::put('{permissionId}', [PermissionController::class, 'update'])->name('update');
        Route::delete('{permissionId}', [PermissionController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('{userId}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('{userId}', [UserController::class, 'update'])->name('update');
        Route::delete('{userId}', [UserController::class, 'destroy'])->name('destroy');
    });

});
