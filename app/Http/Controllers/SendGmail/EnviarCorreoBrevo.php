<?php

namespace App\Http\Controllers\SendGmail;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mensaje\MensajeResource;
use App\Mail\BrevoCorreo;
use App\Models\Mensaje;
use App\Models\Usuario;
use App\Services\Mensaje\MensajeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EnviarCorreoBrevo extends Controller
{
    public function __construct(private MensajeService $mensajeService) {}

    public function enviarCorreo(Request $request)
    {
        $request->validate([
            'to'               => 'required|email',
            'from'             => 'required|email',
            'subject'          => 'required|string',
            'content'          => 'required|string',
            'nombre_remitente' => 'nullable|string|max:100',
            'adjuntos'         => 'nullable|array',
            'adjuntos.*'       => 'file|max:10240',
        ]);

        $usuario = $request->user();
        $nombreRemitente = $request->input('nombre_remitente')
            ?? ($usuario ? trim($usuario->nombre . ' ' . $usuario->apellido) : 'Usuario externo');

        $destinatario = Usuario::where('correo', $request->to)->first();

        $mensaje = $this->mensajeService->guardar(
            [
                'id_remitente'        => $usuario?->id_usuario,
                'nombre_remitente'    => $nombreRemitente,
                'correo_remitente'    => $request->from,
                'id_destinatario'     => $destinatario?->id_usuario,
                'correo_destinatario' => $request->to,
                'asunto'              => $request->subject,
                'contenido'           => $request->content,
            ],
            $request->file('adjuntos') ?? []
        );

        try {
            Mail::mailer('brevo')
                ->to($request->to)
                ->send(new BrevoCorreo(
                    $request->from,
                    $nombreRemitente,
                    $request->subject,
                    $request->content,
                    $request->file('adjuntos') ?? []
                ));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Correo guardado pero no pudo enviarse: ' . $e->getMessage(),
                'mensaje' => new MensajeResource($mensaje),
            ], 500);
        }

        return response()->json([
            'message' => 'Correo enviado correctamente',
            'mensaje' => new MensajeResource($mensaje),
        ], 201);
    }

    public function recibidos(Request $request)
    {
        $correo = $this->resolverCorreo($request);
        $mensajes = $this->mensajeService->recibidos($correo);

        return MensajeResource::collection($mensajes);
    }

    public function enviados(Request $request)
    {
        $correo = $this->resolverCorreo($request);
        $mensajes = $this->mensajeService->enviados($correo);

        return MensajeResource::collection($mensajes);
    }

    private function resolverCorreo(Request $request): string
    {
        $idPortafolio = $request->query('id_portafolio');

        if ($idPortafolio) {
            $portafolio = \App\Models\Portafolio::where('id_portafolio', $idPortafolio)
                ->where('id_usuario', $request->user()->id_usuario)
                ->with('informacionBasica')
                ->first();

            if ($portafolio && $portafolio->informacionBasica?->gmail) {
                return $portafolio->informacionBasica->gmail;
            }
        }

        return $request->user()->correo;
    }

    public function destacar(Request $request, Mensaje $mensaje)
    {
        $idUsuario = $request->user()->id_usuario;
        $destacado = $this->mensajeService->toggleDestacado($mensaje, $idUsuario);

        return response()->json(['destacado' => $destacado]);
    }

    public function destacados(Request $request)
    {
        $correo = $this->resolverCorreo($request);
        $mensajes = $this->mensajeService->destacados($request->user()->id_usuario, $correo);
        return MensajeResource::collection($mensajes);
    }

    public function show(Request $request, string $id)
    {
        if ($id === 'undefined' || !preg_match('/^[0-9a-f-]{36}$/i', $id)) {
            return response()->json(['message' => 'ID de mensaje inválido'], 400);
        }

        $mensaje = Mensaje::findOrFail($id);
        $correo = $request->user()->correo;

        if ($mensaje->correo_destinatario !== $correo && $mensaje->correo_remitente !== $correo) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $mensaje = $this->mensajeService->marcarLeido($mensaje);

        return new MensajeResource($mensaje);
    }
}
