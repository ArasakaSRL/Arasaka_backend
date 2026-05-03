<?php

namespace App\Http\Controllers\Portafolio;

use App\Actions\Reportes\ObtenerReporteAction;
use App\Http\Requests\Reportes\ReporteRequest;
use App\Http\Resources\Reportes\ReporteResource;
use App\Http\Controllers\Controller;

class ReporteController extends Controller
{
    public function index(
        ReporteRequest $request,
        ObtenerReporteAction $action
    ) {
        $data = $action->execute($request->validated());

        return new ReporteResource($data);
    }
}