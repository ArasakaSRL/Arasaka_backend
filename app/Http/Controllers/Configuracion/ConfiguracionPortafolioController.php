<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Configuracion\actualizarConfiguracionRequest;
use App\Http\Resources\ConfiguracionPortafolioResource;
use App\Models\Portafolio;
use App\Services\Configuracion\ConfiguracionService;
use Illuminate\Support\Facades\Auth;

class ConfiguracionPortafolioController extends Controller
{
    public function __construct(
        protected ConfiguracionService $service
    ) {}

    private function getPortafolioId()
    {
        return \App\Models\Portafolio::where('id_usuario', Auth::id())
            ->value('id_portafolio')
            ?? abort(404, 'Portafolio no encontrado');
    }


    public function show()
    {
        $config = $this->service->getByPortafolio(
            $this->getPortafolioId()
        );

        return new ConfiguracionPortafolioResource($config);
    }


    public function update(actualizarConfiguracionRequest $request)
    {
        $config = $this->service->update(
            $this->getPortafolioId(),
            $request->validated()
        );

        return new ConfiguracionPortafolioResource($config);
    }

    //Obtener datos del portafolio con sus relaciones para mostrar en la vista de configuración
    public function showPortafolioCompleto()
    {
        $portafolio = Portafolio::with(['proyectos', 'habilidades', 'experiencias.tipo', 'servicios'])
            ->where('id_usuario', Auth::id())
            ->first();

        if (!$portafolio) {
            return response()->json(null);
        }

        return response()->json($portafolio);
    }
}