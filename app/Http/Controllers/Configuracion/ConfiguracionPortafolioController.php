<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Configuracion\actualizarConfiguracionRequest;
use App\Http\Resources\ConfiguracionPortafolioResource;
use App\Services\Configuracion\ConfiguracionService;

class ConfiguracionPortafolioController extends Controller
{
    public function __construct(
        protected ConfiguracionService $service
    ) {}

    private function getPortafolioId()
    {
        return \App\Models\Portafolio::where('id_usuario', auth()->id())
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
}