<?php

namespace App\Actions\Certificacion;
use App\Models\Portafolio;

class GetCertificacionesByPortafolio {
    public function execute($idPortafolio){
        return Portafolio::with(['certificaciones.categoria'])
            ->findOrFail($idPortafolio)
            ->certificaciones;
    }
}