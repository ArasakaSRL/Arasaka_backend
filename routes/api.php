<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PortafolioController;
use App\Http\Controllers\Api\ProyectoController;

Route::middleware('auth:sanctum')->group(function () {
   

    Route::get('/portafolios', [PortafolioController::class, 'index']);
    Route::post('/portafolios', [PortafolioController::class, 'store']);
    Route::get('/portafolios/{id}', [PortafolioController::class, 'show']);
    Route::put('/portafolios/{id}', [PortafolioController::class, 'update']);
    Route::delete('/portafolios/{id}', [PortafolioController::class, 'destroy']);

    
});

 Route::get('/ping', fn () => response()->json([
        'message' => 'pong',
        'service' => 'Arasaka Backend',
        'enviroment' => app()->environment(),
        'timestamp' => now()->toIso8601String()
    ]));

    Route::get('/proyectos', [ProyectoController::class, 'index']);
    Route::post('/proyectos', [ProyectoController::class, 'store']);
    Route::get('/proyectos/{id}', [ProyectoController::class, 'show']);
    Route::put('/proyectos/{id}', [ProyectoController::class, 'update']);
    Route::delete('/proyectos/{id}', [ProyectoController::class, 'destroy']);