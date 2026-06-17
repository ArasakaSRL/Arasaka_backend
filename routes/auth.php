<?php

use App\Http\Controllers\Auth\FirebaseAuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerificarCodigoRegistroController;
use App\Http\Controllers\Auth\ReenviarCodigoRegistroController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/firebase', [FirebaseAuthController::class, 'login'])
    ->name('auth.firebase');

Route::post('/registrar', [RegisteredUserController::class, 'store'])
    ->name('registrar');

Route::post('/registrar/verificar', VerificarCodigoRegistroController::class)
    ->name('registrar.verificar');

Route::post('/registrar/reenviar', ReenviarCodigoRegistroController::class)
    ->name('registrar.reenviar');

Route::post('/iniciar-sesion', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('iniciar-sesion');

Route::post('/recuperar-contrasena', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('contrasena.correo');

Route::post('/restablecer-contrasena', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('contrasena.restablecer');

Route::get('/verificar-correo/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/correo/notificacion-verificacion', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verificacion.enviar');

Route::post('/cerrar-sesion', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('cerrar-sesion');
