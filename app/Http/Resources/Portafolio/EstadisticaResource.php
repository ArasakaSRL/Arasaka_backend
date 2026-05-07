<?php

namespace App\Http\Resources\Portafolio;

use Illuminate\Http\Resources\Json\JsonResource;

class EstadisticaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'experiencias' => $this['experiencias'],

            'proyectos' => $this['proyectos'], 

            'habilidades' => $this['habilidades'],

            'visitas' => [
                'totales' => $this['visitas']['totales'],
                'unicas' => $this['visitas']['unicas'],
            ],
        ];
    }
}