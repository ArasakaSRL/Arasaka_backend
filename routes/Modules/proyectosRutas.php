<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Proyecto\ProyectoController;

// Rutas para elementos relacionados a portafolios
Route::prefix("/portafolios/{idPortafolio}")->group(function () { // Autenticacion pendiente
    //proyectos
    Route::get("/proyectos", [ProyectoController::class, "index"])->middleware('auth:sanctum')->name('proyectos.index');
    //Route::get("/proyectos/{id}", [ProyectoController::class, "show"])->middleware('auth:sanctum')->name('proyectos.show');
    Route::post("/proyectos", [ProyectoController::class, "store"])->middleware('auth:sanctum')->name('proyectos.store');
    Route::put("/proyectos/{id}", [ProyectoController::class, "update"])->middleware('auth:sanctum')->name('proyectos.update');
    Route::delete("/proyectos/{id}", [ProyectoController::class, "destroy"])->middleware('auth:sanctum')->name('proyectos.destroy');

});