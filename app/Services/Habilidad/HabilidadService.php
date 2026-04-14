<?php

namespace App\Services\Habilidad;

use App\Models\Habilidad;
use Illuminate\Support\Str;
use App\Models\Tecnologia;

class HabilidadService{
    public function crear($data, $idPortafolio){
        //dd($data);
        $nombre = $data['nombre'] ?? Tecnologia::find($data['id_tecnologia'])->nombre ?? 'Habilidad sin nombre';
        
        $habilidad = Habilidad::create([
            'id_habilidad' => Str::uuid(),
            'id_portafolio' => $idPortafolio,
            'nombre' => $nombre,
            'fecha_creacion' => now(),
            'fecha_actualizacion' => now(),
        ]);
        $habilidad->categoria_habilidad = $data['categoria_habilidad'] ?? null;
        $habilidad->nivel = $data['nivel'] ?? null;
        $habilidad->save();
        return $habilidad;
    }

    public function actualizar(array $data, String $idHabilidad){
        //dd($data);
        $habilidad = Habilidad::findOrFail($idHabilidad);

        $nombre = $data['nombre'] ?? Tecnologia::find($data['id_tecnologia'])->nombre ?? 'Habilidad sin nombre';
        
        $habilidad->update(array_merge($data, [
            'nombre' => $nombre,
            'fecha_actualizacion' => now(),
        ]));
        //dd($habilidad);
        return $habilidad;
    }

    public function eliminar(Habilidad $habilidad){
        $habilidad->delete();
    }
}