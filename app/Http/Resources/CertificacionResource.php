<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificacionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id_certificacion' => $this->id_certificacion,
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'institucion_emisora' => $this->institucion_emisora,
            'fecha_obtencion' => $this->fecha_obtencion ,
            'url_archivo' => $this->url_archivo,
            'orientacion_imagen' => $this->orientacion_imagen,
            'categoria_certificacion' => [
                'id_categoria_certificacion' => $this->categoria ? $this->categoria->id_categoria_certificacion : null,
                'nombre_categoria' => $this->categoria ? $this->categoria->nombre : null,
                'descripcion_categoria' => $this->categoria ? $this->categoria->descripcion : null,
                'url_imagen' => $this->categoria ? $this->categoria->url_imagen : null,
            ]
        ];
    }
}