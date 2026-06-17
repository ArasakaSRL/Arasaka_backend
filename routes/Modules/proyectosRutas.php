<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Proyecto\ProyectoController;

Route::middleware('auth:sanctum')->prefix('portafolios/{idPortafolio}')->group(function () {
    Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyectos.index');
    Route::post('/proyectos', [ProyectoController::class, 'store'])->name('proyectos.store');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/portafolios/proyectos/{id}', [ProyectoController::class, 'show'])->name('proyectos.show');
    Route::put('/portafolios/proyectos/{id}', [ProyectoController::class, 'update'])->name('proyectos.update');
    Route::delete('/portafolios/proyectos/{id}', [ProyectoController::class, 'destroy'])->name('proyectos.destroy');
});
