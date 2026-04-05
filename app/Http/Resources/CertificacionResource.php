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
            'fecha_obtencion' => $this->fecha_obtencion,
            'url_archivo' => $this->url_archivo,
            'orientacion_imagen' => $this->orientacion_imagen,

            // Relación segura
            'categoria_certificacion' => $this->whenLoaded('categoria', function () {
                return [
                    'id_categoria_certificacion' => $this->categoria->id_categoria_certificacion,
                    'nombre_categoria' => $this->categoria->nombre,
                    'descripcion_categoria' => $this->categoria->descripcion,
                    'url_imagen' => $this->categoria->url_imagen,
                ];
            }),
        ];
    }
}