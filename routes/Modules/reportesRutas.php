<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportesUsr\HeatmapController;

Route::prefix('public')->group(function () {
    Route::post('/heatmap/iniciar',       [HeatmapController::class, 'iniciar']);
    Route::post('/heatmap/perfil/track',  [HeatmapController::class, 'track']); 
    Route::post('/heatmap/habilidades-blandas/track',      [HeatmapController::class, 'trackHabilidadBlanda']);
});