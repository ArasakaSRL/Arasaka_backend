<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portafolio\PublicPortafolioController;
use App\Http\Controllers\Portafolio\PortafolioPreviewController;
use App\Http\Controllers\Portafolio\PortafolioLinkController;
use App\Http\Controllers\Configuracion\ConfiguracionPortafolioController;

Route::middleware('auth:sanctum')->prefix('configuracion')->group(function () {
    Route::get('/', [ConfiguracionPortafolioController::class, 'show']);
    Route::put('/', [ConfiguracionPortafolioController::class, 'update']);

    Route::get('/portafolio/{slug}', [PortafolioPreviewController::class, 'show']);
    Route::get('/portafolio-link', [PortafolioLinkController::class, 'show']);
    Route::post('/portafolio-link', [PortafolioLinkController::class, 'generar']);
});

Route::middleware('auth:sanctum')->get('/usuario/Miportafolio', [ConfiguracionPortafolioController::class, 'showPortafolioCompleto']);

Route::get('/public/portafolio/{slug}', [PublicPortafolioController::class, 'show']);