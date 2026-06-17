<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Tecnologia\TecnologiaController;
use App\Http\Controllers\Tecnologia\TecnologiasController;

Route::prefix('tecnologia')->group(function () {

    Route::get('/', [TecnologiasController::class, 'index']);
    Route::post('/', [TecnologiasController::class, 'store']);
    Route::get('/{id}', [TecnologiasController::class, 'show']);
    Route::put('/{id}', [TecnologiasController::class, 'update']);
    Route::delete('/{id}', [TecnologiasController::class, 'destroy']);

});
// Rutas para tecnologías
Route::get("/tecnologias", [TecnologiaController::class, "index"]);
