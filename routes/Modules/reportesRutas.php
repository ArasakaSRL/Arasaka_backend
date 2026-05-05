<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportesUsr\HeatmapController;

Route::prefix('public/heatmap')->group(function () {
    Route::post('/iniciar',                       [HeatmapController::class, 'iniciar']);
    Route::post('/perfil/track',                  [HeatmapController::class, 'track']); 
    Route::post('/habilidades-blandas/track',     [HeatmapController::class, 'trackHabilidadBlanda']);
    Route::post('/habilidades-tecnicas/track',    [HeatmapController::class, 'trackHabilidadTecnica']);
    Route::post('/experiencia/track',             [HeatmapController::class, 'trackExperiencia']);
    Route::post('/proyecto/track',                [HeatmapController::class, 'trackProyecto']);
    Route::post('/certificacion/track',           [HeatmapController::class, 'trackCertificacion']);
    Route::post('/perfil/clic-coords', [HeatmapController::class, 'trackClicCoords']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('reportesUsr')->group(function () {
        Route::get('/heatmap/visitantes', [HeatmapController::class, 'getVisitantes']);
        Route::get('/heatmap/perfil',     [HeatmapController::class, 'getInteraccionesPerfil']);
        Route::get('/heatmap/habilidades-tecnicas',   [HeatmapController::class, 'getInteraccionesHabilidadesTecnicas']);
        Route::get('/heatmap/perfil/clics', [HeatmapController::class, 'getClicsPerfil']);
    });
});