<?php

namespace App\Services\Proyecto;

use App\Models\Proyecto;
use Illuminate\Support\Str;

class ProyectoService {
    public function crear($data ,$idPortafolio){
        $proyecto = Proyecto::create([
            'id_proyecto' => Str::uuid(),
            'id_portafolio' => $idPortafolio,
            ...$data
        ]);
        $proyecto->tecnologias()->sync($data['tecnologias']);
        return $proyecto;
    }

    public function actualizar($data, $id){
        $proyecto = Proyecto::find($id);
        $proyecto->update($data);
        //dd($proyecto);
        return $proyecto;
    }

    public function eliminar(Proyecto $proyecto){
        $proyecto->delete();
    }
}