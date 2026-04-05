<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Experiencia\ExperienciaController;

Route::prefix("experiencias")
    ->middleware("auth:sanctum")
    ->group(function () {

        Route::get("/", [ExperienciaController::class, "index"]);
        Route::get("{id}", [ExperienciaController::class, "show"]);
        Route::post("/", [ExperienciaController::class, "store"]);
        Route::put("{id}", [ExperienciaController::class, "update"]);
        Route::delete("{id}", [ExperienciaController::class, "destroy"]);
        Route::get("portafolio/{portafolioId}", [
            ExperienciaController::class,
            "byPortafolio",
        ]);
    });

