<?php

use App\Http\Controllers\Configuracion\ConfiguracionPortafolioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Usuario\UsuarioController;
use App\Http\Controllers\Profesion\ProfesionController;

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

    Route::patch('/usuario/pais', [UsuarioController::class, 'actualizarPais']);
    Route::get('/usuario/telefonos', [UsuarioController::class, 'getTelefonos']);
    Route::post('/usuario/telefonos', [UsuarioController::class, 'agregarTelefono']);
    Route::patch('/usuario/telefonos/{id}', [UsuarioController::class, 'actualizarTelefono']);
    Route::delete('/usuario/telefonos/{id}', [UsuarioController::class, 'eliminarTelefono']);

});
