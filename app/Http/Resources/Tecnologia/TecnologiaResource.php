<?php

namespace App\Http\Resources\Tecnologia;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TecnologiaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_tecnologia' => $this->id_tecnologia,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'logo' => $this->logo,
        ];
    }
}