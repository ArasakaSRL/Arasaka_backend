<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Habilidad\HabilidadController;

Route::middleware('auth:sanctum')->prefix('portafolios/{idPortafolio}')->group(function () {
    Route::get('/habilidades', [HabilidadController::class, 'index'])->name('habilidades.index');
    Route::post('/habilidades', [HabilidadController::class, 'store'])->name('habilidades.store');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::put('/portafolios/habilidades/{id}', [HabilidadController::class, 'update'])->name('habilidades.update');
    Route::delete('/portafolios/habilidades/{id}', [HabilidadController::class, 'destroy'])->name('habilidades.destroy');
});
