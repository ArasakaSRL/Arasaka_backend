<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portafolio\PublicPortafolioController;

Route::get('/public/portafolio/{slug}', [PublicPortafolioController::class, 'show']);