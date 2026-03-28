<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PortafolioController;
use App\Http\Controllers\Api\ProyectoController;
use App\Http\Controllers\Api\TecnologiaController;
use App\Http\Controllers\Api\HabilidadController;
use App\Http\Controllers\Api\CategoriaHabilidadController;
use App\Http\Controllers\Api\NivelHabilidadController;

Route::get('/ping', fn () => response()->json([
        'message' => 'pong',
        'service' => 'Arasaka Backend',
        'enviroment' => app()->environment(),
        'timestamp' => now()->toIso8601String()
    ]));

Route::middleware('auth:sanctum')->group(function () {
   

    Route::get('/portafolios', [PortafolioController::class, 'index']);
    Route::post('/portafolios', [PortafolioController::class, 'store']);
    Route::get('/portafolios/{id}', [PortafolioController::class, 'show']);
    Route::put('/portafolios/{id}', [PortafolioController::class, 'update']);
    Route::delete('/portafolios/{id}', [PortafolioController::class, 'destroy']);

    
});

    // Rutas para proyectos
    Route::get('/proyectos', [ProyectoController::class, 'index']);
    Route::post('/proyectos', [ProyectoController::class, 'store']);
    Route::get('/proyectos/{id}', [ProyectoController::class, 'show']);
    Route::put('/proyectos/{id}', [ProyectoController::class, 'update']);
    Route::delete('/proyectos/{id}', [ProyectoController::class, 'destroy']);

    // Rutas para tecnologías
    Route::get('/tecnologias', [TecnologiaController::class, 'index']);

    // Rutas para habilidades
    Route::post('/habilidades', [HabilidadController::class, 'store']);

    // rutas para categorías de habilidades
    Route::get('/categorias-habilidad', [CategoriaHabilidadController::class, 'index']);

    // ruta para niveles de habilidad
    Route::get('/niveles-habilidad', [NivelHabilidadController::class, 'index']);