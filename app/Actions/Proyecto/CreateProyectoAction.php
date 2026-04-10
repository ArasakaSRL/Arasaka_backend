<?php

namespace App\Actions\Proyecto;

use App\Services\Proyecto\ProyectoService;

class CreateProyectoAction {
    public function __construct(protected ProyectoService $service)
    {}

    public function execute($data, $idPortafolio){
        return $this->service->crear($data, $idPortafolio);
    }
}