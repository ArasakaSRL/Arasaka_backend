<?php

namespace App\Http\Controllers\Portafolio;

use App\Http\Controllers\Controller;
use App\Models\Portafolio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PortafolioIdiomaController extends Controller
{
    private function verificarPropietario(Portafolio $portafolio): bool
    {
        return $portafolio->id_usuario === auth()->user()->id_usuario;
    }

    public function index(Portafolio $portafolio): JsonResponse
    {
        if (!$this->verificarPropietario($portafolio)) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        return response()->json(['data' => $portafolio->idiomas]);
    }

    public function asignar(Request $request, Portafolio $portafolio): JsonResponse
    {
        if (!$this->verificarPropietario($portafolio)) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $data = $request->validate(['id_idioma' => 'required|uuid|exists:idioma,id_idioma']);

        $portafolio->idiomas()->syncWithoutDetaching([$data['id_idioma']]);

        return response()->json(['message' => 'Idioma asignado correctamente.'], 201);
    }

    public function desasignar(Portafolio $portafolio, string $idIdioma): JsonResponse
    {
        if (!$this->verificarPropietario($portafolio)) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $portafolio->idiomas()->detach($idIdioma);

        return response()->json(['message' => 'Idioma desasignado correctamente.']);
    }
}
