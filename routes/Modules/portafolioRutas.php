<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portafolio\PublicPortafolioController;
use App\Http\Controllers\Portafolio\PortafolioPreviewController;
use App\Http\Controllers\Portafolio\PortafolioLinkController;
use App\Http\Controllers\Portafolio\ImageProxyController;
use App\Http\Controllers\Configuracion\ConfiguracionPortafolioController;
use App\Http\Controllers\Portafolio\ReporteController;
use App\Http\Controllers\Portafolio\PortafolioEstadisticaController;


Route::get(
    'portafolios/{id_portafolio}/estadisticas',
    [PortafolioEstadisticaController::class, 'show']
);

Route::get(
    'mi-portafolio/estadisticas',
    [PortafolioEstadisticaController::class, 'show']
)->middleware('auth:sanctum');

Route::get('/reportes', [ReporteController::class, 'index'])
    ->middleware('auth:sanctum');
    
Route::middleware('auth:sanctum')->prefix('configuracion')->group(function () {
    Route::get('/', [ConfiguracionPortafolioController::class, 'show']);
    Route::put('/', [ConfiguracionPortafolioController::class, 'update']);

    Route::get('/portafolio/{slug}', [PortafolioPreviewController::class, 'show']);
    Route::get('/portafolio-link', [PortafolioLinkController::class, 'show']);
    Route::post('/portafolio-link', [PortafolioLinkController::class, 'generar']);
});

Route::middleware('auth:sanctum')->get('/usuario/Miportafolio', [ConfiguracionPortafolioController::class, 'showPortafolioCompleto']);

Route::get('/public/portafolio/{slug}', [PublicPortafolioController::class, 'show']);

Route::get('/public/image-proxy', [ImageProxyController::class, 'fetch']);
Route::get('/public/portafolios', [PublicPortafolioController::class, 'index']);
