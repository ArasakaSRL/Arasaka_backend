<?php

namespace App\Actions\Portafolio;

use App\Services\Portafolio\PortafolioService;

class ObtenerPortafolioPreviewAction
{
    public function __construct(
        private PortafolioService $service
    ) {}

    public function execute(string $slug, string $idUsuario)
    {
        return $this->service->obtenerParaPreview($slug, $idUsuario);
    }
}
