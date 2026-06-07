<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DenunciaAdminController;
use App\Http\Controllers\Admin\SystemConfigController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('/admin')->group(function () {
    Route::get('/users', [AdminController::class, 'indexAllUsuarios'])->name('users.index');

    // Denuncias y suspensiones
    Route::get('/denuncias',               [DenunciaAdminController::class, 'denuncias']);
    Route::get('/portafolios-suspendidos', [DenunciaAdminController::class, 'portafoliosSuspendidos']);
    Route::get('/usuarios-suspendidos',    [DenunciaAdminController::class, 'usuariosSuspendidos']);

    // Configuración del sistema
    Route::get('/system-config',  [SystemConfigController::class, 'show']);
    Route::put('/system-config',  [SystemConfigController::class, 'update']);
});

