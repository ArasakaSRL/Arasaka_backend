<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ProyectoController;
use App\Http\Controllers\Api\TecnologiaController;
use App\Http\Controllers\Api\HabilidadController;
use App\Http\Controllers\Api\CategoriaHabilidadController;
use App\Http\Controllers\Api\NivelHabilidadController;
use App\Http\Controllers\Usuario\UsuarioController;

Route::get(
  "/ping",
  fn() => response()->json([
    "message" => "pong",
    "service" => "Arasaka Backend",
    "enviroment" => app()->environment(),
    "timestamp" => now()->toIso8601String(),
  ])
);


// Rutas para elementos relacionados a portafolios
Route::prefix("portafolios/{idPortafolio}")->group(function () { // Autenticacion pendiente
    //proyectos
    Route::get("/proyectos", [ProyectoController::class, "index"]);
    Route::post("/proyectos", [ProyectoController::class, "store"]);
    Route::get("/proyectos/{id}", [ProyectoController::class, "show"]);
    Route::put("/proyectos/{id}", [ProyectoController::class, "update"]);
    Route::delete("/proyectos/{id}", [ProyectoController::class, "destroy"]);
});

// Rutas para tecnologías
Route::get("/tecnologias", [TecnologiaController::class, "index"]);

// Rutas para habilidades
Route::post("/habilidades", [HabilidadController::class, "store"]);

// rutas para categorías de habilidades
Route::get("/categorias-habilidad", [
  CategoriaHabilidadController::class,
  "index",
]);

// ruta para niveles de habilidad
Route::get("/niveles-habilidad", [NivelHabilidadController::class, "index"]);

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
require __DIR__ . "/Modules/certificaciones.php";
require __DIR__ . "/Modules/experiencia.php";
