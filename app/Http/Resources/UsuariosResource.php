<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuariosResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_usuario' => $this->id_usuario,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'username' => $this->username,
            'correo' => $this->correo,
            'rol' => $this->rol,
            'url_foto' => $this->url_foto,
            'portafolios' => $this->portafolios ?? $this->portafolios->map(function ($p){
                return[
                    'id_portafolio' => $p->id_portafolio,
                    'nombre' => $p->nombre
                ];
            }),
            'created_at' => $this->created_at?->format('d-m-Y H:i:s'),
            'updated_at' => $this->updated_at?->format('d-m-Y H:i:s'),
        ];
    }
}
