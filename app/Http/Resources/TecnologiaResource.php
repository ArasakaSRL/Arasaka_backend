<?php

namespace App\Http\Resources\Proyectos;
use Illuminate\Http\Resources\Json\JsonResource;    

class TecnologiaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id_tecnologia' => $this->id_tecnologia,
            'nombre_tecnologia' => $this->nombre,
            'icono_tecnologia' => $this->logo,
        ];
    }
}