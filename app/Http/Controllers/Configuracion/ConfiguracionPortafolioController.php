<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Configuracion\actualizarConfiguracionRequest;
use App\Http\Resources\ConfiguracionPortafolioResource;
use App\Models\Portafolio;
use App\Services\Configuracion\ConfiguracionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfiguracionPortafolioController extends Controller
{
    public function __construct(
        protected ConfiguracionService $service
    ) {}

    private function resolverPortafolioId(Request $request): string
    {
        $idPortafolio = $request->query('id_portafolio');

        if ($idPortafolio) {
            return Portafolio::where('id_portafolio', $idPortafolio)
                ->where('id_usuario', Auth::id())
                ->value('id_portafolio')
                ?? abort(404, 'Portafolio no encontrado');
        }

        return Portafolio::where('id_usuario', Auth::id())
            ->value('id_portafolio')
            ?? abort(404, 'Portafolio no encontrado');
    }

    public function show(Request $request)
    {
        $config = $this->service->getByPortafolio(
            $this->resolverPortafolioId($request)
        );

        return new ConfiguracionPortafolioResource($config);
    }

    public function update(actualizarConfiguracionRequest $request)
    {
        $config = $this->service->update(
            $this->resolverPortafolioId($request),
            $request->validated()
        );

        return new ConfiguracionPortafolioResource($config);
    }

    //Obtener datos del portafolio con sus relaciones para mostrar en la vista de configuración
    public function showPortafolioCompleto(Request $request)
    {
        $query = Portafolio::with(['proyectos', 'habilidades', 'experiencias.tipo', 'servicios'])
            ->where('id_usuario', Auth::id());

        $idPortafolio = $request->query('id_portafolio');
        if ($idPortafolio) {
            $query->where('id_portafolio', $idPortafolio);
        }

        $portafolio = $query->first();

        if (!$portafolio) {
            return response()->json(null);
        }

        return response()->json($portafolio);
    }
}