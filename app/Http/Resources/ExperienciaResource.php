<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExperienciaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_experiencia,
            'id_portafolio' => $this->id_portafolio,
            'id_tipo_experiencia' => $this->id_tipo_experiencia ?? null,
            'cargo' => $this->cargo,
            'nombre_organizacion' => $this->nombre_organizacion,
            'descripcion' => $this->descripcion,
            'fecha_inicio' => $this->fecha_inicio?->format('Y-m-d'),
            'fecha_fin' => $this->fecha_fin?->format('Y-m-d'),
            'vigente' => $this->vigente,
            'tipo' => $this->tipo?->nombre ?? null,
            'portafolio' => $this->portafolio?->nombre ?? null,
        ];
    }
}