<?php

namespace App\Actions\Certificacion;

use App\Models\Certificacion;

class GetCertificacionesOrdenadasAction
{
    public function execute(string $idPortafolio)
    {
        return Certificacion::where(
            'id_portafolio',
            $idPortafolio
        )
        ->orderBy('fecha_obtencion', 'desc')
        ->get();
    }
}