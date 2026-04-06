<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Proyecto\ProyectoController;
use App\Http\Controllers\Tecnologia\TecnologiaController;
use App\Http\Controllers\Habilidad\HabilidadController;
use App\Http\Controllers\Habilidad\CategoriaHabilidadController;
use App\Http\Controllers\Habilidad\NivelHabilidadController;
use App\Http\Controllers\Usuario\UsuarioController;
use App\Http\Controllers\Profesion\ProfesionController;

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

// Rutas para profesiones
Route::get("/profesiones", [ProfesionController::class, "index"]);
Route::get("/profesiones/{id}", [ProfesionController::class, "show"]);

Route::middleware('auth:sanctum')->group(function () {

    // Info del usuario autenticado
    Route::get('/usuario', fn(Request $request) => $request->user());

    // Profesiones del usuario
    Route::get('/usuario/profesiones', [UsuarioController::class, 'getProfesiones']);
    Route::post('/usuario/profesiones', [UsuarioController::class, 'asignarProfesion']);
    Route::delete('/usuario/profesiones/{id}', [UsuarioController::class, 'desasignarProfesion']);

    // Editar info del usuario
    Route::patch('/usuario/informacion', [UsuarioController::class, 'actualizarInformacion']);
    Route::patch('/usuario/foto', [UsuarioController::class, 'actualizarFoto']);    
});

require __DIR__ . "/auth.php";
require __DIR__ . "/Modules/proyectosRutas.php";
require __DIR__ . "/Modules/habilidadesRutas.php";
require __DIR__ . "/Modules/tecnologiasRutas.php";
require __DIR__ . "/Modules/certificacionesRutas.php";
require __DIR__ . "/Modules/experienciaRutas.php";
