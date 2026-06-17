<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SendGmail\EnviarCorreo;
use App\Http\Controllers\SendGmail\EnviarCorreoBrevo;

Route::post("/enviar-correo", [EnviarCorreo::class, "enviarCorreo"])->name('enviar.correo');
Route::post("/enviar-correo-brevo", [EnviarCorreoBrevo::class, "enviarCorreo"])->name('enviar.correo.brevo');

Route::middleware('auth:sanctum')->group(function () {
    Route::get("/mensajes/recibidos", [EnviarCorreoBrevo::class, "recibidos"])->name('mensajes.recibidos');
    Route::get("/mensajes/enviados",  [EnviarCorreoBrevo::class, "enviados"])->name('mensajes.enviados');
    Route::get("/mensajes/destacados", [EnviarCorreoBrevo::class, "destacados"])->name('mensajes.destacados');
    Route::post("/mensajes/{mensaje}/destacar", [EnviarCorreoBrevo::class, "destacar"])->name('mensajes.destacar');
    Route::get("/mensajes/{mensaje}", [EnviarCorreoBrevo::class, "show"])->name('mensajes.show');
});