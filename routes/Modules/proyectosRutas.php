<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Proyecto\ProyectoController;

// Rutas para elementos relacionados a portafolios
Route::prefix("/portafolios")->group(function () { // Autenticacion pendiente
    //proyectos
    Route::get("/proyectos", [ProyectoController::class, "index"]);
    Route::post("/proyectos", [ProyectoController::class, "store"])->middleware('auth:sanctum')->name('proyectos.store');
});