<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormacionAcademicaController;

Route::prefix('formacion-academica')->group(function () {

    Route::post('/', [FormacionAcademicaController::class, 'store']);

    Route::get('/', [FormacionAcademicaController::class, 'index']);
    Route::get(
    '/portafolio/{id_portafolio}',
    [FormacionAcademicaController::class, 'obtenerPorPortafolio']
);
    Route::get('/{id}', [FormacionAcademicaController::class, 'show']);

    Route::put('/{id}', [FormacionAcademicaController::class, 'update']);

    Route::delete('/{id}', [FormacionAcademicaController::class, 'destroy']);
});