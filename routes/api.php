<?php

use Illuminate\Support\Facades\Route;

Route::get(
  "/ping",
  fn() => response()->json([
    "message" => "pong",
    "service" => "Arasaka Backend",
    "enviroment" => app()->environment(),
    "timestamp" => now()->toIso8601String(),
  ])
);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/autenticar', fn() => response()->json([
        "message" => "Autenticado correctamente",
        "user" => request()->user(),
    ]));
});

require __DIR__ . "/auth.php";
require __DIR__ . "/Modules/profesionesRutas.php";
require __DIR__ . "/Modules/proyectosRutas.php";
require __DIR__ . "/Modules/habilidadesRutas.php";
require __DIR__ . "/Modules/tecnologiasRutas.php";
require __DIR__ . "/Modules/certificacionesRutas.php";
require __DIR__ . "/Modules/experienciaRutas.php";
