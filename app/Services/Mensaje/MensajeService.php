<?php

namespace App\Services\Mensaje;

use App\Models\AdjuntoMensaje;
use App\Models\Mensaje;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MensajeService
{
    public function guardar(array $data, array $archivos = []): Mensaje
    {
        $mensaje = Mensaje::create([
            'id_mensaje'          => (string) Str::uuid(),
            'id_remitente'        => $data['id_remitente'] ?? null,
            'nombre_remitente'    => $data['nombre_remitente'],
            'correo_remitente'    => $data['correo_remitente'],
            'id_destinatario'     => $data['id_destinatario'] ?? null,
            'correo_destinatario' => $data['correo_destinatario'],
            'asunto'              => $data['asunto'],
            'contenido'           => $data['contenido'],
        ]);

        foreach ($archivos as $archivo) {
            $ruta = $archivo->store("mensajes/{$mensaje->id_mensaje}", 'public');

            AdjuntoMensaje::create([
                'id_adjunto'     => (string) Str::uuid(),
                'id_mensaje'     => $mensaje->id_mensaje,
                'nombre_archivo' => $archivo->getClientOriginalName(),
                'url_archivo'    => Storage::url($ruta),
                'tipo_mime'      => $archivo->getMimeType(),
            ]);
        }

        return $mensaje->fresh(['adjuntos']);
    }

    public function recibidos(string $correo, int $perPage = 15)
    {
        return Mensaje::where('correo_destinatario', $correo)
            ->with('adjuntos')
            ->orderByDesc('fecha_envio')
            ->paginate($perPage);
    }

    public function enviados(string $correo, int $perPage = 15)
    {
        return Mensaje::where('correo_remitente', $correo)
            ->with('adjuntos')
            ->orderByDesc('fecha_envio')
            ->paginate($perPage);
    }

    public function marcarLeido(Mensaje $mensaje): Mensaje
    {
        $mensaje->update(['leido' => true]);
        return $mensaje->load('adjuntos');
    }
}
