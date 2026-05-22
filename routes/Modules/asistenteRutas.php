<?php

use App\Http\Controllers\Asistente\AsistenteController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->post('/asistente', [AsistenteController::class, 'chat']);
