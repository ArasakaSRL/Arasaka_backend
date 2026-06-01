<?php

use App\Http\Controllers\Configuracion\ConfiguracionPortafolioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route; 

use App\Http\Controllers\Usuario\UsuarioController;
use App\Http\Controllers\Usuario\CambiarCorreoController;
use App\Http\Controllers\Profesion\ProfesionController;

// Rutas para profesiones
Route::get("/profesiones", [ProfesionController::class, "index"]);
Route::get("/profesiones/{id}", [ProfesionController::class, "show"]);

Route::middleware('auth:sanctum')->group(function () {

    // Info del usuario autenticado
    Route::get('/usuario', function (Request $request) {
        $user = $request->user()->load('portafolio:id_usuario,slug');
        $tienePassword  = !is_null($user->password);
        $perfilCompleto = !is_null($user->password) && !is_null($user->username);

        if ($perfilCompleto && !$user->tour_completado) {
            $user->update(['tour_completado' => true]);
        }

        $user->tiene_password  = $tienePassword;
        $user->perfil_completo = $perfilCompleto;
        return $user;
    });

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
    Route::patch('/usuario/contrasena', [UsuarioController::class, 'cambiarContrasena']);
    Route::post('/usuario/completar-perfil', [UsuarioController::class, 'completarPerfil']);
    Route::patch('/usuario/tour', [UsuarioController::class, 'completarTour']);
    Route::post('/usuario/correo/verificar', [CambiarCorreoController::class, 'verificar']);
    Route::post('/usuario/correo/confirmar', [CambiarCorreoController::class, 'confirmar']);

});
