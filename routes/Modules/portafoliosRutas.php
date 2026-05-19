<?php
use App\Http\Controllers\Portafolio\PortafolioController;

Route::middleware('auth:sanctum')
    ->prefix('portafolios')
    ->group(function () {

        Route::get(
            '/',
            [PortafolioController::class, 'listar']
        );

        Route::post(
            '/',
            [PortafolioController::class, 'crear']
        );

        Route::get(
            '/{portafolio}',
            [PortafolioController::class, 'mostrar']
        );

        Route::put(
            '/{portafolio}',
            [PortafolioController::class, 'actualizar']
        );

        Route::delete(
            '/{portafolio}',
            [PortafolioController::class, 'eliminar']
        );
    });