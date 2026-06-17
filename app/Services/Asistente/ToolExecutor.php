<?php

namespace App\Services\Asistente;

use App\Actions\Habilidad\GetHabilidadByPortafolioAction;
use App\Actions\Proyecto\GetProyectosByPortafolio;
use App\Mail\BrevoCorreo;
use App\Models\Usuario;
use App\Services\Experiencia\ExperienciaService;
use App\Services\Mensaje\MensajeService;
use Illuminate\Support\Facades\Mail;

class ToolExecutor
{
    public function __construct(
        private MensajeService $mensajeService,
        private ExperienciaService $experienciaService,
        private GetProyectosByPortafolio $getProyectosAction,
        private GetHabilidadByPortafolioAction $getHabilidadesAction,
    ) {}

    public function execute(string $toolName, string $argumentsJson, Usuario $usuario): array
    {
        $args = json_decode($argumentsJson, true) ?? [];

        return match ($toolName) {
            'obtener_proyectos'          => $this->obtenerProyectos($usuario),
            'obtener_mensajes_recibidos' => $this->obtenerMensajesRecibidos($usuario),
            'obtener_habilidades'        => $this->obtenerHabilidades($usuario),
            'obtener_experiencias'       => $this->obtenerExperiencias($usuario),
            'enviar_correo'              => $this->enviarCorreo($usuario, $args),
            default                      => ['error' => "Tool '{$toolName}' no reconocida"],
        };
    }

    private function obtenerProyectos(Usuario $usuario): array
    {
        $portafolio = $usuario->portafolio;
        if (!$portafolio) {
            return ['proyectos' => [], 'total' => 0];
        }

        $proyectos = $this->getProyectosAction->execute($portafolio->id_portafolio)
            ->map(fn($p) => [
                'nombre'      => $p->nombre,
                'descripcion' => $p->descripcion,
                'tecnologias' => $p->tecnologias->pluck('nombre'),
            ]);

        return ['proyectos' => $proyectos, 'total' => $proyectos->count()];
    }

    private function obtenerMensajesRecibidos(Usuario $usuario): array
    {
        $mensajes = $this->mensajeService->recibidos($usuario->correo, 10)
            ->map(fn($m) => [
                'de'       => $m->nombre_remitente ?? $m->correo_remitente,
                'asunto'   => $m->asunto,
                'contenido'=> $m->contenido,
                'fecha'    => optional($m->fecha_envio ?? $m->created_at)->format('d/m/Y'),
                'leido'    => $m->leido ?? false,
            ]);

        return ['mensajes' => $mensajes, 'total' => $mensajes->count()];
    }

    private function obtenerHabilidades(Usuario $usuario): array
    {
        $portafolio = $usuario->portafolio;
        if (!$portafolio) {
            return ['habilidades' => [], 'total' => 0];
        }

        $habilidades = $this->getHabilidadesAction->execute($portafolio->id_portafolio)
            ->map(fn($h) => [
                'nombre' => $h->nombre,
            ]);

        return ['habilidades' => $habilidades, 'total' => $habilidades->count()];
    }

    private function obtenerExperiencias(Usuario $usuario): array
    {
        $portafolio = $usuario->portafolio;
        if (!$portafolio) {
            return ['experiencias' => [], 'total' => 0];
        }

        $experiencias = $this->experienciaService->listByPortafolio($portafolio->id_portafolio)
            ->map(fn($e) => [
                'empresa' => $e->empresa,
                'cargo'   => $e->cargo,
                'inicio'  => $e->fecha_inicio,
                'fin'     => $e->fecha_fin ?? 'Actualidad',
            ]);

        return ['experiencias' => $experiencias, 'total' => $experiencias->count()];
    }

    private function enviarCorreo(Usuario $usuario, array $args): array
    {
        if (empty($args['to']) || empty($args['subject']) || empty($args['content'])) {
            return ['error' => 'Faltan parámetros: to, subject, content'];
        }

        $nombreRemitente = trim($usuario->nombre . ' ' . $usuario->apellido);
        $destinatario = Usuario::where('correo', $args['to'])->first();

        $this->mensajeService->guardar([
            'id_remitente'        => $usuario->id_usuario,
            'nombre_remitente'    => $nombreRemitente,
            'correo_remitente'    => $usuario->correo,
            'id_destinatario'     => $destinatario?->id_usuario,
            'correo_destinatario' => $args['to'],
            'asunto'              => $args['subject'],
            'contenido'           => $args['content'],
        ], []);

        try {
            Mail::mailer('brevo')
                ->to($args['to'])
                ->send(new BrevoCorreo(
                    $usuario->correo,
                    $nombreRemitente,
                    $args['subject'],
                    $args['content'],
                    []
                ));
        } catch (\Exception $e) {
            return ['error' => 'Correo guardado pero no pudo enviarse: ' . $e->getMessage()];
        }

        return ['success' => true, 'message' => "Correo enviado correctamente a {$args['to']}"];
    }
}
