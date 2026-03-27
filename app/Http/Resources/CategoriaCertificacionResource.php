<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoriaCertificacionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id_categoria_certificacion,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'url_imagen' => $this->url_imagen,
        ];
    }
}