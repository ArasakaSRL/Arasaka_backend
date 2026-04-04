<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PortafolioController;
use App\Http\Controllers\Proyecto\ProyectoController;
use App\Http\Controllers\Tecnologia\TecnologiaController;
use App\Http\Controllers\Habilidad\HabilidadController;
use App\Http\Controllers\Habilidad\CategoriaHabilidadController;
use App\Http\Controllers\Habilidad\NivelHabilidadController;
use App\Http\Controllers\Certificacion\CategoriaCertificacionController;
use App\Http\Controllers\Certificacion\CertificacionController;
use App\Http\Controllers\Experiencia\ExperienciaController;
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

Route::middleware("auth:sanctum")->group(function () {
  Route::get("/portafolios", [PortafolioController::class, "index"]);
  Route::post("/portafolios", [PortafolioController::class, "store"]);
  Route::get("/portafolios/{id}", [PortafolioController::class, "show"]);
  Route::put("/portafolios/{id}", [PortafolioController::class, "update"]);
  Route::delete("/portafolios/{id}", [PortafolioController::class, "destroy"]);
});

// Rutas para elementos relacionados a portafolios
Route::prefix("portafolios/{idPortafolio}")->group(function () { // Autenticacion pendiente
    //proyectos
    Route::get("/proyectos", [ProyectoController::class, "index"]);
    Route::post("/proyectos", [ProyectoController::class, "store"]);
    Route::get("/proyectos/{id}", [ProyectoController::class, "show"]);
    Route::put("/proyectos/{id}", [ProyectoController::class, "update"]);
    Route::delete("/proyectos/{id}", [ProyectoController::class, "destroy"]);

    Route::get("/habilidades", [HabilidadController::class, "index"]);
});

// Rutas para profesiones
Route::get("/profesiones", [ProfesionController::class, "index"]);
Route::get("/profesiones/{id}", [ProfesionController::class, "show"]);

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

Route::prefix("categorias")->group(function () {
  Route::get("/", [CategoriaCertificacionController::class, "index"]);
  Route::post("/", [CategoriaCertificacionController::class, "store"]);
  Route::get("/{id}", [CategoriaCertificacionController::class, "show"]);
  Route::put("/{categoria}", [
    CategoriaCertificacionController::class,
    "update",
  ]);
  Route::delete("/{categoria}", [
    CategoriaCertificacionController::class,
    "destroy",
  ]);
});

Route::prefix("portafolios/{idPortafolio}")->group(function () {
  Route::get("certificaciones", [CertificacionController::class, "index"]);
  Route::post("certificaciones", [CertificacionController::class, "store"]);
});

Route::get("certificaciones/{certificacion}", [
  CertificacionController::class,
  "show",
]);
Route::put("certificaciones/{certificacion}", [
  CertificacionController::class,
  "update",
]);
Route::delete("certificaciones/{certificacion}", [
  CertificacionController::class,
  "destroy",
]);
Route::get(
  "portafolios/{idPortafolio}/certificaciones/categoria/{idCategoria}",
  [CertificacionController::class, "byCategoria"]
);

Route::delete("portafolios/{idPortafolio}/certificaciones", [
  CertificacionController::class,
  "deleteByPortafolio",
]);

Route::prefix("experiencias")->group(function () {
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
