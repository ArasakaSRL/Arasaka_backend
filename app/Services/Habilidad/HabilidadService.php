<?php

namespace App\Services\Habilidad;

use App\Models\Habilidad;
use Illuminate\Support\Str;
use App\Models\Tecnologia;

class HabilidadService{
    public function crear($data, $idPortafolio)
{
    $nombre = $data['nombre'] 
        ?? Tecnologia::find($data['id_tecnologia'])->nombre 
        ?? 'Habilidad sin nombre';

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

   
    if (
        $habilidad->categoria_habilidad?->value === 'tecnica' &&
        !empty($data['id_tecnologia'])
    ) {
        $habilidad->tecnologias()->attach($data['id_tecnologia']);
    }

    return $habilidad;
}

    public function actualizar(array $data, String $idHabilidad){
        $habilidad = Habilidad::findOrFail($idHabilidad);
        if (array_key_exists('id_tecnologia', $data)) {
            $data['nombre'] = Tecnologia::findOrFail($data['id_tecnologia'])->nombre;
        }
        $habilidad->update(array_merge($data, [
            'fecha_actualizacion' => now(),
        ]));
        //dd($habilidad);
        return $habilidad;
    }

    public function eliminar(Habilidad $habilidad){
        $habilidad->delete();
    }
}