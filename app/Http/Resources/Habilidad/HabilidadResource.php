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
    public function toArray($request)
    {
        return [
            'id_habilidad' => $this->id_habilidad,
            'id_portafolio' => $this->id_portafolio,
            'id_categoria_habilidad' => $this->id_categoria_habilidad,
            'id_nivel_habilidad' => $this->id_nivel_habilidad,
            'nombre' => $this->nombre,
        ];
    }
}