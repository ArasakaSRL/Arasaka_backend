
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Certificacion\CertificacionController;
use App\Http\Controllers\Certificacion\CategoriaCertificacionController;

Route::middleware('auth:sanctum')->group(function () {

  
    Route::prefix('portafolios/{idPortafolio}')->group(function () {
        Route::get('certificaciones', [CertificacionController::class, 'index']);
        Route::post('certificaciones', [CertificacionController::class, 'store']);
        Route::delete('certificaciones', [CertificacionController::class, 'deleteByPortafolio']);

        
        Route::get('certificaciones/categoria/{idCategoria}', [
            CertificacionController::class,
            'byCategoria'
        ]);
    });

    Route::prefix('certificaciones')->group(function () {
        Route::get('{certificacion}', [CertificacionController::class, 'show']);
        Route::put('{certificacion}', [CertificacionController::class, 'update']);
        Route::delete('{certificacion}', [CertificacionController::class, 'destroy']);
    });

Route::prefix("categorias")->group(function () {
  Route::get("/", [CategoriaCertificacionController::class, "index"]);
  Route::post("/", [CategoriaCertificacionController::class, "store"]);
  Route::get("/{id}", [CategoriaCertificacionController::class, "show"]);
  Route::put("/{categoria}", [
    CategoriaCertificacionController::class,
    "update",
  ]);
  Route::delete("/{categoria}", [
    CategoriaCertificacionController::class,
    "destroy",
  ]);
});

});

