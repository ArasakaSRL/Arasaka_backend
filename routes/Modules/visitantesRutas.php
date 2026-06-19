<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VisitantesController; 

Route::prefix('visitantes')->group(function () {
    Route::get('/', [VisitantesController::class, 'obtenerDatosVisitantes']);
});