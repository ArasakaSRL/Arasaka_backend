<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Tecnologia\TecnologiaController;

// Rutas para tecnologías
Route::get("/tecnologias", [TecnologiaController::class, "index"]);
