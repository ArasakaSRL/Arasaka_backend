<?php

namespace App\Actions\Habilidad;

use App\Services\Habilidad\HabilidadService;

class CreateHabilidadAction{
    public function __construct(protected HabilidadService $service)
    {}

    public function execute($data, $idPortafolio){
        return $this->service->crear($data, $idPortafolio);
    }
}