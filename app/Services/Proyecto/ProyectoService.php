<?php

namespace App\Services\Proyecto;

use App\Models\Proyecto;
use Illuminate\Support\Str;

class ProyectoService {
    public function crear($data ,$idPortafolio){
        return Proyecto::create([
            'id_proyecto' => Str::uuid(),
            'id_portafolio' => $idPortafolio,
            ...$data
        ]);
    }

    public function actualizar(Proyecto $proyecto, $data){
        $proyecto->update($data);
        return $proyecto;
    }

    public function eliminar(Proyecto $proyecto){
        $proyecto->delete();
    }
}