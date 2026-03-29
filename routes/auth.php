<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::post('/registrar', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('registrar');

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
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verificacion.verificar');

Route::post('/correo/notificacion-verificacion', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verificacion.enviar');

Route::post('/cerrar-sesion', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('cerrar-sesion');
