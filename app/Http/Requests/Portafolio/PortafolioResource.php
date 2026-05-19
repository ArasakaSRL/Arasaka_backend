<?php

namespace App\Http\Resources\Portafolio;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PortafolioResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_portafolio' => $this->id_portafolio,

            'nombre' => $this->nombre,

            'descripcion' => $this->descripcion,

            'slug' => $this->slug,

            'visibilidad' => $this->visibilidad,

            'link_publico' => [
                'activo' => $this->link_activo,
                'fecha_expiracion' => $this->fecha_expiracion_link,
                'duracion' => $this->duracion_link,
            ],

            'configuracion' => $this->configuracion,

            'visualizaciones' => $this->visualizaciones,

            'fecha_creacion' => $this->fecha_creacion,

            'fecha_actualizacion' => $this->fecha_actualizacion,
        ];
    }
}