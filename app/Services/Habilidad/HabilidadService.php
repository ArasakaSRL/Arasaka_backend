<?php

namespace App\Services\Habilidad;

use App\Models\Habilidad;
use Illuminate\Support\Str;

class HabilidadService{
    public function crear($data, $idPortafolio){
        return Habilidad::create([
            'id_habilidad' => Str::uuid(),
            'id_portafolio' => $idPortafolio,
            ...$data,
        ]);
    }

    public function actualizar(Habilidad $habilidad, $data){
        $Habilidad->update($data);
        return $habilidad;
    }

    public function eliminar(Habilidad $habilidad){
        $habilidad->delete();
    }
}