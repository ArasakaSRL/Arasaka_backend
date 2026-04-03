<?php

namespace App\Http\Resources\Proyectos;
use Illuminate\Http\Resources\Json\JsonResource;

class ProyectoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id_proyecto' => $this->id_proyecto,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'url_repositorio' => $this->url_repositorio,
            'url_demo' => $this->url_demo,
            'tecnologias' => $this->tecnologias ? $this->tecnologias->map(function ($tecnologia) {
                return [
                    'id_tecnologia' => $tecnologia->id_tecnologia,
                    'nombre_tecnologia' => $tecnologia->nombre_tecnologia,
                    'icono_tecnologia' => $tecnologia->icono_tecnologia,
                ];
            }) : [],
            'fecha_inicio' => $this->fecha_inicio?->format('d-m-Y'),
            'fecha_fin' => $this->fecha_fin?->format('d-m-Y'),
        ];
    }
}   

