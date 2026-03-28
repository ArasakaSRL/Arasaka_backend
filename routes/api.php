<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PortafolioController;

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/portafolios', [PortafolioController::class, 'index']);
    Route::post('/portafolios', [PortafolioController::class, 'store']);
    Route::get('/portafolios/{id}', [PortafolioController::class, 'show']);
    Route::put('/portafolios/{id}', [PortafolioController::class, 'update']);
    Route::delete('/portafolios/{id}', [PortafolioController::class, 'destroy']);

});