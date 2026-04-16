<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portafolio\PublicPortafolioController;
use App\Http\Controllers\Configuracion\ConfiguracionPortafolioController;

Route::middleware('auth:sanctum')->prefix('configuracion')->group(function () {
    Route::get('/', [ConfiguracionPortafolioController::class, 'show']);
    Route::put('/', [ConfiguracionPortafolioController::class, 'update']);
});
Route::get('/public/portafolio/{slug}', [PublicPortafolioController::class, 'show']);