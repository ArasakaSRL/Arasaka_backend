<?php

namespace App\Http\Controllers\Portafolio;

use App\Actions\Portafolio\GetEstadisticasPortafolio;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portafolio\EstadisticaRequest;
use App\Http\Resources\Portafolio\EstadisticaResource;

class PortafolioEstadisticaController extends Controller
{
    public function show(
        EstadisticaRequest $request,
        GetEstadisticasPortafolio $action
    ) {
        $user = $request->user(); 

        $data = $action->execute(
            $request->id_portafolio,
            $user
        );

        return new EstadisticaResource($data);
    }
}