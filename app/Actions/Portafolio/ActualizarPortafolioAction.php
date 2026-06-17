<?php

namespace App\Actions\Portafolio;

use App\Models\Portafolio;

class ActualizarPortafolioAction
{
    public function ejecutar(
        Portafolio $portafolio,
        array $datos
    ): Portafolio {

        $portafolio->update([
            'nombre' =>
                $datos['nombre']
                ?? $portafolio->nombre,

            'descripcion' =>
                $datos['descripcion']
                ?? $portafolio->descripcion,

            'visibilidad' =>
                $datos['visibilidad']
                ?? $portafolio->visibilidad,

            'fecha_actualizacion' => now(),
        ]);

        return $portafolio->fresh([
            'configuracion',
            'visualizaciones',
        ]);
    }
}