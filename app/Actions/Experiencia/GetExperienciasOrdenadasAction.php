<?php

namespace App\Actions\Experiencia;

use App\Models\Experiencia;

class GetExperienciasOrdenadasAction
{
    public function execute(string $idPortafolio)
    {
        return Experiencia::where(
            'id_portafolio',
            $idPortafolio
        )
        ->orderBy('fecha_inicio', 'desc')
        ->get();
    }
}