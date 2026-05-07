<?php

namespace App\Actions\Certificacion;
use App\Models\Portafolio;

class GetCertificacionesByPortafolio {

    public function execute($idPortafolio){
        return \App\Models\Certificacion::with('categoria')
            ->where('id_portafolio', $idPortafolio)
            ->get();
    }
}