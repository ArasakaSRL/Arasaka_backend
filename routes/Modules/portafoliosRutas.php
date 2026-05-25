<?php

use App\Http\Controllers\Portafolio\InformacionBasicaController;
use App\Http\Controllers\Portafolio\PortafolioController;
use App\Http\Controllers\Portafolio\PortafolioIdiomaController;
use App\Http\Controllers\Portafolio\PortafolioProfesionController;
use App\Http\Controllers\Portafolio\PortafolioTelefonoController;
use Illuminate\Support\Facades\Route;

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

        Route::patch(
            '/{portafolio}/informacion-basica',
            [InformacionBasicaController::class, 'actualizar']
        );

        Route::post(
            '/{portafolio}/informacion-basica/foto',
            [InformacionBasicaController::class, 'subirFoto']
        );

        // Teléfonos del portafolio
        Route::get('/{portafolio}/telefonos', [PortafolioTelefonoController::class, 'index']);
        Route::post('/{portafolio}/telefonos', [PortafolioTelefonoController::class, 'store']);
        Route::patch('/{portafolio}/telefonos/{id}', [PortafolioTelefonoController::class, 'update']);
        Route::delete('/{portafolio}/telefonos/{id}', [PortafolioTelefonoController::class, 'destroy']);

        // Idiomas del portafolio
        Route::get('/{portafolio}/idiomas', [PortafolioIdiomaController::class, 'index']);
        Route::post('/{portafolio}/idiomas', [PortafolioIdiomaController::class, 'asignar']);
        Route::delete('/{portafolio}/idiomas/{idIdioma}', [PortafolioIdiomaController::class, 'desasignar']);

        // Profesiones del portafolio
        Route::get('/{portafolio}/profesiones', [PortafolioProfesionController::class, 'index']);
        Route::post('/{portafolio}/profesiones', [PortafolioProfesionController::class, 'asignar']);
        Route::delete('/{portafolio}/profesiones/{idProfesion}', [PortafolioProfesionController::class, 'desasignar']);
    });