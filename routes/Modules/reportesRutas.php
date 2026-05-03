<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportesUsr\HeatmapController;

Route::prefix('public')->group(function () {
    Route::post('/heatmap/iniciar',       [HeatmapController::class, 'iniciar']);
    Route::post('/heatmap/perfil/track',  [HeatmapController::class, 'track']); 
    Route::post('/heatmap/habilidades-blandas/track',      [HeatmapController::class, 'trackHabilidadBlanda']);
    Route::post('/heatmap/habilidades-tecnicas/track',    [HeatmapController::class, 'trackHabilidadTecnica']);
    Route::post('/heatmap/experiencia/track',             [HeatmapController::class, 'trackExperiencia']);
    Route::post('/heatmap/proyecto/track',                [HeatmapController::class, 'trackProyecto']);
});