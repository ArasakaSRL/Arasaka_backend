<?php

namespace App\Http\Resources\Proyectos;
use Illuminate\Http\Resources\Json\JsonResource;

class ProyectoResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id_proyecto' => $this->id_proyecto,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'url_github' => $this->url_github,
            'url_demo' => $this->url_demo,
            'tecnologias' => $this->tecnologias ? $this->tecnologias->map(function ($tecnologia) {
                return [
                    'id_tecnologia' => $tecnologia->id_tecnologia,
                    'nombre' => $tecnologia->nombre,
                    'logo' => $tecnologia->logo,
                ];
            }) : [],
            'url_imagen' => $this->imagenes ? $this->imagenes->map(function ($url_imagen) {
                return [
                    'id_url_imagen' => $url_imagen->id_url_imagen_proyecto,
                    'id_proyecto' => $url_imagen->id_proyecto,
                    'url_imagen' => $url_imagen->url_imagen,
                ];
            }) : [],
            'fecha_inicio' => $this->fecha_inicio?->format('d-m-Y'),
            'fecha_fin' => $this->fecha_fin?->format('d-m-Y'),
        ];
    }
}   

