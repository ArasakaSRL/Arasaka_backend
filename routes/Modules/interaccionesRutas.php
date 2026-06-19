<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InteraccionesController; 

Route::prefix('interacciones')->group(function () {
    Route::get('/', [InteraccionesController::class, 'obtenerTodas']);
    
    // Para más adelante si se necesita sacar datos por visitante, podrías agregar algo como:
    // Route::get('/visitante/{id}', [InteraccionesController::class, 'porVisitante']);
});