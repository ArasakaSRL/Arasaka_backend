<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Habilidad\HabilidadController;

Route::prefix('portafolios')->group(function () {
    // Rutas para habilidades
    Route::get("/habilidades", [HabilidadController::class, "index"])->middleware('auth:sanctum')->name('habilidades.index');   
    Route::post("/habilidades", [HabilidadController::class, "store"])->middleware('auth:sanctum')->name('habilidades.store');
    Route::put("/habilidades/{id}", [HabilidadController::class, "update"])->middleware('auth:sanctum')->name('habilidades.update');
    Route::delete("/habilidades/{id}", [HabilidadController::class, "destroy"])->middleware('auth:sanctum')->name('habilidades.destroy');
   
}); 

