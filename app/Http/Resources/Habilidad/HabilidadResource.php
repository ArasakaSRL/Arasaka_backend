<?php

namespace App\Http\Resources\Habilidad;

use Illuminate\Http\Resources\Json\JsonResource;

class HabilidadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'id_habilidad' => $this->id_habilidad,
            'id_portafolio' => $this->id_portafolio,
            'categoria habilidad' => $this->categoria_habilidad?->value,
            'nivel habilidad' => $this->nivel?->value,
            'nombre' => $this->nombre,
        ];
    }
}