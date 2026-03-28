<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PortafolioController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\HabilidadController;

Route::apiResource('habilidades', HabilidadController::class);
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/portafolios', [PortafolioController::class, 'index']);
    Route::post('/portafolios', [PortafolioController::class, 'store']);
    Route::get('/portafolios/{id}', [PortafolioController::class, 'show']);
    Route::put('/portafolios/{id}', [PortafolioController::class, 'update']);
    Route::delete('/portafolios/{id}', [PortafolioController::class, 'destroy']);

});



Route::prefix('proyectos')->group(function () {
    Route::get('/', [ProyectoController::class, 'index']);
    Route::get('/{id}', [ProyectoController::class, 'show']);
    Route::post('/', [ProyectoController::class, 'store']);
    Route::put('/{id}', [ProyectoController::class, 'update']);
    Route::delete('/{id}', [ProyectoController::class, 'destroy']);
});

Route::post('/habilidades', [HabilidadController::class, 'store']);