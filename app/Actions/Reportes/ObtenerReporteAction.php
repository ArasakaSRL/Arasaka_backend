<?php

namespace App\Actions\Reportes;

use App\Services\Reportes\ReporteService;

class ObtenerReporteAction
{
    public function __construct(
        private ReporteService $service
    ) {}

    public function execute(array $data)
    {
        // 🔥 Resolver id_portafolio
        $data['id_portafolio'] = $data['id_portafolio']
            ?? auth()->user()?->portafolio?->id_portafolio;

        if (!$data['id_portafolio']) {
            throw new \Exception('No se pudo determinar el portafolio');
        }

        return $this->service->obtener($data);
    }
}