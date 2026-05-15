<?php

namespace App\Services\Mensaje;

use App\Models\AdjuntoMensaje;
use App\Models\Mensaje;
use App\Models\MensajeDestacado;
use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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
            $mime = $archivo->getMimeType();
            $resourceType = match(true) {
                str_starts_with($mime, 'image/') => 'image',
                str_starts_with($mime, 'video/') => 'video',
                default                          => 'raw',
            };

            $resultado = Cloudinary::uploadApi()->upload(
                $archivo->getRealPath(),
                [
                    'folder'        => "mensajes/{$mensaje->id_mensaje}",
                    'resource_type' => $resourceType,
                ]
            );

            AdjuntoMensaje::create([
                'id_adjunto'     => (string) Str::uuid(),
                'id_mensaje'     => $mensaje->id_mensaje,
                'nombre_archivo' => $archivo->getClientOriginalName(),
                'url_archivo'    => $resultado['secure_url'],
                'public_id'      => $resultado['public_id'],
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

    public function toggleDestacado(Mensaje $mensaje, string $idUsuario): bool
    {
        $existente = MensajeDestacado::where('id_usuario', $idUsuario)
            ->where('id_mensaje', $mensaje->id_mensaje)
            ->first();

        if ($existente) {
            $existente->delete();
            return false;
        }

        MensajeDestacado::create([
            'id_destacado' => (string) Str::uuid(),
            'id_usuario'   => $idUsuario,
            'id_mensaje'   => $mensaje->id_mensaje,
        ]);

        return true;
    }

    public function destacados(string $idUsuario, int $perPage = 15)
    {
        return Mensaje::whereHas('destacados', fn($q) => $q->where('id_usuario', $idUsuario))
            ->with('adjuntos')
            ->orderByDesc('fecha_envio')
            ->paginate($perPage);
    }
}
