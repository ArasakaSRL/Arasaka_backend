<?php

namespace App\Services\Habilidad;

use App\Models\Habilidad;
use Illuminate\Support\Str;
use App\Models\Tecnologia;

class HabilidadService{
    public function crear($data, $idPortafolio){
        //dd($data);
        $nombre = $data['nombre'] ?? Tecnologia::find($data['id_tecnologia'])->nombre ?? 'Habilidad sin nombre';
        return Habilidad::create([
            'id_habilidad' => Str::uuid(),
            'id_portafolio' => $idPortafolio,
            'nombre' => $nombre,
            ...$data
        ]);
    }

    public function actualizar($data, String $idHabilidad){
        $habilidad = Habilidad::find($idHabilidad);
        $habilidad->fecha_actualizacion = now();
        $habilidad->update($data);
        return $habilidad;
    }

    public function eliminar(Habilidad $habilidad){
        $habilidad->delete();
    }
}