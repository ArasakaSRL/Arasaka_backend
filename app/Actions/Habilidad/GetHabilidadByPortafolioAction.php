<?php

namespace App\Actions\Habilidad;

use App\Models\Habilidad;

class GetHabilidadByPortafolioAction{
    public function execute($idPortafolio){
        return Habilidad::where("id_portafolio", $idPortafolio)
                ->orderBy('fecha_creacion', 'desc')
                ->get();
    }
}