<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Experiencia\ExperienciaController;

Route::middleware('auth:sanctum')->prefix('portafolios/{idPortafolio}/experiencias')->group(function () {
    Route::get('/', [ExperienciaController::class, 'index']);

    Route::get('/timeline', [ExperienciaController::class, 'timeline']);

    Route::post('/', [ExperienciaController::class, 'store']);
    Route::get('/{id}', [ExperienciaController::class, 'show']);
    Route::put('/{id}', [ExperienciaController::class, 'update']);
    Route::delete('/multiple', [ExperienciaController::class, 'destroyMultiple']);
    Route::delete('/{id}', [ExperienciaController::class, 'destroy']);
});
