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

Route::get('/autenticar', function () {
    $user = request()->user('sanctum');
    if (!$user) {
        return response()->json([
            "message" => "No autenticado",
            "user" => null,
        ]);
    }
    $user->load([
        'roles',
        'portafolios.informacionBasica',
        'portafolios.telefonos',
        'portafolios.profesiones',
        'portafolios.idiomas',
        'portafolios.configuracion',
    ]);
    return response()->json([
        "message" => "Autenticado correctamente",
        "user" => $user,
    ]);
});

require __DIR__ . "/auth.php";
require __DIR__ . "/Modules/profesionesRutas.php";
require __DIR__ . "/Modules/proyectosRutas.php";
require __DIR__ . "/Modules/habilidadesRutas.php";
require __DIR__ . "/Modules/tecnologiasRutas.php";
require __DIR__ . "/Modules/certificacionesRutas.php";
require __DIR__ . "/Modules/experienciaRutas.php";
require __DIR__ . "/Modules/portafolioRutas.php";
require __DIR__ . "/Modules/sendGmail.php";
require __DIR__ . "/Modules/reportesRutas.php";
require __DIR__ . "/Modules/asistenteRutas.php";
require __DIR__ . "/Modules/portafoliosRutas.php";
