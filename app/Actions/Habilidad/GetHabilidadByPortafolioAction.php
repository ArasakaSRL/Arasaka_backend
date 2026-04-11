<?php

namespace App\Actions\Habilidad;

use App\Models\Habilidad;

class GetHabilidadByPortafolioAction{
    public function execute($idPortafolio){
        return Habilidad::with(['categoria:id_categoria_habilidad,nombre', 'nivel:id_nivel_habilidad,nivel'])
                ->where("id_portafolio", $idPortafolio)
                ->orderBy('fecha_creacion', 'desc')
                ->get();
    }
}