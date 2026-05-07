<?php

namespace App\Actions\Certificacion; 
use App\Services\Certificacion\CertificacionService;

class CreateCertificacion {
    public function __construct( protected  CertificacionService $service)
    {}
    public function execute($data, $idPortafolio){
        return $this->service->crear($data, $idPortafolio);
    }
}