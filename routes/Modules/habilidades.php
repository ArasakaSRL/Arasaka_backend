<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Habilidad\HabilidadController;
use App\Http\Controllers\Habilidad\CategoriaHabilidadController;
use App\Http\Controllers\Habilidad\NivelHabilidadController;


Route::get("/habilidades", [HabilidadController::class, "index"]);


// Rutas para habilidades

Route::post("/habilidades", [HabilidadController::class, "store"]);

// rutas para categorías de habilidades
Route::get("/categorias-habilidad", [CategoriaHabilidadController::class,"index"]);

// ruta para niveles de habilidad
Route::get("/niveles-habilidad", [NivelHabilidadController::class, "index"]);
