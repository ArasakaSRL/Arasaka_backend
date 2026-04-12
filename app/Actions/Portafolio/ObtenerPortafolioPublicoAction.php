<?php

namespace App\Actions\Portafolio;

use App\Services\Portafolio\PortafolioService;

class ObtenerPortafolioPublicoAction
{
    public function __construct(
        private PortafolioService $service
    ) {}

    public function execute(string $slug)
    {
        return $this->service->obtenerPublicoPorSlug($slug);
    }
}