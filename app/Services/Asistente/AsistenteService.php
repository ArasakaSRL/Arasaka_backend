<?php

namespace App\Services\Asistente;

use App\Models\Usuario;
use OpenAI\Laravel\Facades\OpenAI;
// use OpenAI\Laravel\Facades\OpenAI; // OpenAI — ya importado, usado en el bloque comentado de abajo

class AsistenteService
{
    /**
     * El AsistenteService es responsable de manejar la lógica de conversación con el asistente virtual.
     * Actualmente usa Groq (llama-3.1-8b-instant) — gratuito.
     * Para volver a OpenAI: descomentar el use OpenAI arriba, comentar el cliente Groq,
     * y cambiar el modelo a 'gpt-4o-mini'.
     */
    public function __construct(private ToolExecutor $toolExecutor) {}

    private function groqClient(): \OpenAI\Client
    {
        // Cliente Groq — compatible con la API de OpenAI, solo cambia la base URL
        $apiKey = config('groq.api_key') ?: env('GROQ_API_KEY');

        return \OpenAI::factory()
            ->withApiKey($apiKey)
            ->withBaseUri('https://api.groq.com/openai/v1')
            ->make();
    }

    public function chat(string $mensaje, Usuario $usuario): string
    {
        $systemPrompt = $this->buildSystemPrompt($usuario);

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user',   'content' => $mensaje],
        ];

        // GROQ (activo) 
        $client = $this->groqClient();
        $response = $client->chat()->create([
            'model'    => 'llama-3.1-8b-instant',
            'messages' => $messages,
            'tools'    => $this->getTools(),
        ]);

        // $response = OpenAI::chat()->create([
        //     'model'    => 'gpt-4o-mini',
        //     'messages' => $messages,
        //     'tools'    => $this->getTools(),
        // ]);

        $choice = $response->choices[0];

        if ($choice->finishReason === 'tool_calls') {
            return $this->handleToolCalls($choice, $messages, $usuario);
        }

        return $choice->message->content;
    }

    /**
     * Maneja las llamadas a herramientas generadas por el modelo.
     * Ejecuta las herramientas necesarias y genera una respuesta final basada en los resultados.
     */
    private function handleToolCalls($choice, array $messages, Usuario $usuario): string
    {
        $assistantMessage = [
            'role'       => 'assistant',
            'content'    => null,
            'tool_calls' => array_map(fn($tc) => [
                'id'       => $tc->id,
                'type'     => 'function',
                'function' => [
                    'name'      => $tc->function->name,
                    'arguments' => $tc->function->arguments,
                ],
            ], $choice->message->toolCalls),
        ];

        $messages[] = $assistantMessage;

        foreach ($choice->message->toolCalls as $toolCall) {
            $resultado = $this->toolExecutor->execute(
                $toolCall->function->name,
                $toolCall->function->arguments,
                $usuario
            );

            $messages[] = [
                'role'         => 'tool',
                'tool_call_id' => $toolCall->id,
                'content'      => json_encode($resultado),
            ];
        }

        // --- GROQ (activo) ---
        $finalResponse = $this->groqClient()->chat()->create([
            'model'    => 'llama-3.1-8b-instant',
            'messages' => $messages,
        ]);

        // --- OPENAI (comentado) ---
        // $finalResponse = OpenAI::chat()->create([
        //     'model'    => 'gpt-4o-mini',
        //     'messages' => $messages,
        // ]);

        return $finalResponse->choices[0]->message->content;
    }

    /**
     * Construye el prompt del sistema basado en la información del usuario.
     */
    private function buildSystemPrompt(Usuario $usuario): string
    {
        $portafolio = $usuario->portafolio;

        return "Eres el asistente virtual de Arasaka, una plataforma de portafolios profesionales.

La plataforma permite a los usuarios:
- Crear y gestionar su portafolio profesional
- Agregar proyectos con tecnologías utilizadas
- Registrar habilidades técnicas y blandas
- Documentar experiencias laborales y educativas
- Agregar certificaciones con categorías
- Configurar redes profesionales (LinkedIn, GitHub, etc.)
- Recibir mensajes de contacto de otras personas
- Ver estadísticas y analíticas de visitas a su portafolio
- Compartir su portafolio mediante un enlace público

Usuario actual:
- Nombre: {$usuario->nombre} {$usuario->apellido}
- Correo: {$usuario->correo}
- Portafolio: " . ($portafolio->nombre ?? 'sin portafolio') . "
- Biografía: " . ($usuario->biografia ?? 'no definida') . "

Instrucciones:
- Responde siempre en español.
- Sé conciso, amable y útil.
- Cuando el usuario pregunte sobre sus proyectos, mensajes, habilidades o experiencias, usa las herramientas disponibles para obtener datos reales.
- No inventes información sobre los datos del usuario.";
    }

    /**
     * Obtiene la lista de herramientas disponibles para el asistente.
     */
    private function getTools(): array
    {
        return [
            [
                'type' => 'function',
                'function' => [
                    'name'        => 'obtener_proyectos',
                    'description' => 'Obtiene los proyectos del portafolio del usuario autenticado',
                    'parameters'  => ['type' => 'object', 'properties' => new \stdClass(), 'required' => []],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name'        => 'obtener_mensajes_recibidos',
                    'description' => 'Obtiene los últimos mensajes recibidos del usuario',
                    'parameters'  => ['type' => 'object', 'properties' => new \stdClass(), 'required' => []],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name'        => 'obtener_habilidades',
                    'description' => 'Obtiene las habilidades del portafolio del usuario',
                    'parameters'  => ['type' => 'object', 'properties' => new \stdClass(), 'required' => []],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name'        => 'obtener_experiencias',
                    'description' => 'Obtiene las experiencias laborales del usuario',
                    'parameters'  => ['type' => 'object', 'properties' => new \stdClass(), 'required' => []],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name'        => 'enviar_correo',
                    'description' => 'Envía un correo electrónico en nombre del usuario',
                    'parameters'  => [
                        'type'       => 'object',
                        'properties' => [
                            'to'      => ['type' => 'string', 'description' => 'Email del destinatario'],
                            'subject' => ['type' => 'string', 'description' => 'Asunto del correo'],
                            'content' => ['type' => 'string', 'description' => 'Cuerpo del mensaje'],
                        ],
                        'required' => ['to', 'subject', 'content'],
                    ],
                ],
            ],
        ];
    }
}
