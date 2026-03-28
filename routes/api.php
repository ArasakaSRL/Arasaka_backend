<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PortafolioController;
use App\Http\Controllers\Certificacion\CategoriaCertificacionController;
use App\Http\Controllers\Certificacion\CertificacionController;
use App\Http\Controllers\Experiencia\ExperienciaController;

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/portafolios', [PortafolioController::class, 'index']);
    Route::post('/portafolios', [PortafolioController::class, 'store']);
    Route::get('/portafolios/{id}', [PortafolioController::class, 'show']);
    Route::put('/portafolios/{id}', [PortafolioController::class, 'update']);
    Route::delete('/portafolios/{id}', [PortafolioController::class, 'destroy']);

});



Route::prefix('categorias')->group(function () {
    Route::get('/', [CategoriaCertificacionController::class, 'index']);
    Route::post('/', [CategoriaCertificacionController::class, 'store']);
    Route::get('/{id}', [CategoriaCertificacionController::class, 'show']);
    Route::put('/{categoria}', [CategoriaCertificacionController::class, 'update']);
    Route::delete('/{categoria}', [CategoriaCertificacionController::class, 'destroy']);
});

Route::prefix('portafolios/{idPortafolio}')->group(function () {
    Route::get('certificaciones', [CertificacionController::class, 'index']);
    Route::post('certificaciones', [CertificacionController::class, 'store']);
});

Route::get('certificaciones/{certificacion}', [CertificacionController::class, 'show']);
Route::put('certificaciones/{certificacion}', [CertificacionController::class, 'update']);
Route::delete('certificaciones/{certificacion}', [CertificacionController::class, 'destroy']);
Route::get(
    'portafolios/{idPortafolio}/certificaciones/categoria/{idCategoria}',
    [CertificacionController::class, 'byCategoria']
);

Route::delete(
    'portafolios/{idPortafolio}/certificaciones',
    [CertificacionController::class, 'deleteByPortafolio']
);

Route::prefix('experiencias')->group(function () {
    Route::get('/', [ExperienciaController::class, 'index']);
    Route::get('{id}', [ExperienciaController::class, 'show']);
    Route::post('/', [ExperienciaController::class, 'store']);
    Route::put('{id}', [ExperienciaController::class, 'update']);
    Route::delete('{id}', [ExperienciaController::class, 'destroy']);
    Route::get('portafolio/{portafolioId}', [ExperienciaController::class, 'byPortafolio']);
});