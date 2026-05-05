<?php

namespace App\Http\Resources\Mensaje;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MensajeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id_mensaje,
            'remitente'   => [
                'nombre' => $this->nombre_remitente,
                'correo' => $this->correo_remitente,
            ],
            'destinatario' => [
                'correo' => $this->correo_destinatario,
            ],
            'asunto'      => $this->asunto,
            'contenido'   => $this->contenido,
            'leido'       => $this->leido,
            'fecha_envio' => $this->fecha_envio?->toDateTimeString(),
            'adjuntos'    => $this->adjuntos->map(fn($a) => [
                'nombre' => $a->nombre_archivo,
                'url'    => $a->url_archivo,
                'tipo'   => $a->tipo_mime,
            ]),
        ];
    }
}
