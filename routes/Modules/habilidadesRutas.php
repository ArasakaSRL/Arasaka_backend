<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Habilidad\HabilidadController;

Route::prefix('portafolios')->group(function () {
    // Rutas para habilidades
    Route::get("{/habilidades", [HabilidadController::class, "index"])->middleware('auth:sanctum')->name('habilidades.index.default');   
    Route::get("{idPortafolio?}/habilidades", [HabilidadController::class, "index"])->middleware('auth:sanctum')->name('habilidades.index.byIdPortafolio');   
    Route::post("/habilidades", [HabilidadController::class, "store"])->middleware('auth:sanctum')->name('habilidades.store.default');
    Route::post("{idPortafolio?}/habilidades", [HabilidadController::class, "store"])->middleware('auth:sanctum')->name('habilidades.store.byIdPortafolio');
    Route::put("/habilidades/{id}", [HabilidadController::class, "update"])->middleware('auth:sanctum')->name('habilidades.update');
    Route::delete("/habilidades/{id}", [HabilidadController::class, "destroy"])->middleware('auth:sanctum')->name('habilidades.destroy');
   
}); 

