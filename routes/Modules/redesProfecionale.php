<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedesProfesionalesController;

Route::prefix('portafolios')->group(function () {

    
    Route::get(
        '/{id_portafolio}/redes-profesionales',
        [RedesProfesionalesController::class, 'index']
    );

  
    Route::post(
        '/{id_portafolio}/redes-profesionales',
        [RedesProfesionalesController::class, 'store']
    );
    Route::put(
        '/{id_portafolio}/redes-profesionales',
        [RedesProfesionalesController::class, 'update']
    );
});