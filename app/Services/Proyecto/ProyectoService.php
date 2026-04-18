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

    public function actualizar(array $data, $id){
        $proyecto = Proyecto::findOrFail($id);
        $proyecto->update(array_merge($data,[
            'fecha_actualizacion'=> now()
        ]));
        // 1. Verificamos que la llave exista
        if (array_key_exists('tecnologias', $data) && is_array($data['tecnologias'])) {
        
        // 2. Limpiamos cadenas vacías, nulos o espacios en blanco
            $tecnologiasLimpias = array_filter($data['tecnologias'], function($valor) {
                return !empty(trim($valor)); 
            });

        // 3. Solo sincronizamos si el array NO quedó vacío tras la limpieza
            if (!empty($tecnologiasLimpias)) {
                $proyecto->tecnologias()->sync($tecnologiasLimpias);
            }
        }
        
        return $proyecto;
    }

    public function eliminar(Proyecto $proyecto){
        $proyecto->delete();
    }
}