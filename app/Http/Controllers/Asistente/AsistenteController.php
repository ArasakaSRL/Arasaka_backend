<?php

namespace App\Http\Controllers\Asistente;

use App\Http\Controllers\Controller;
use App\Services\Asistente\AsistenteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AsistenteController extends Controller
{
    public function __construct(private AsistenteService $asistenteService) {}

    /**
     * funcion para manejar las conversaciones con el asistente virtual,
     *  recibe un mensaje del usuario y devuelve una respuesta generada
     *  por el asistente utilizando inteligencia artificial.
     */
    public function chat(Request $request): JsonResponse
    {
        $data = $request->validate([
            'mensaje' => 'required|string|max:1000',
        ]);

        $respuesta = $this->asistenteService->chat($data['mensaje'], $request->user());

        return response()->json(['respuesta' => $respuesta]);
    }
}
