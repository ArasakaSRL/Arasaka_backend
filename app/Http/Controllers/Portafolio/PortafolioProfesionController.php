<?php

namespace App\Http\Controllers\Portafolio;

use App\Http\Controllers\Controller;
use App\Models\Portafolio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PortafolioProfesionController extends Controller
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

        return response()->json(['data' => $portafolio->profesiones]);
    }

    public function asignar(Request $request, Portafolio $portafolio): JsonResponse
    {
        if (!$this->verificarPropietario($portafolio)) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $data = $request->validate(['id_profesion' => 'required|uuid|exists:profesion,id_profesion']);

        $portafolio->profesiones()->syncWithoutDetaching([$data['id_profesion']]);

        return response()->json(['message' => 'Profesión asignada correctamente.'], 201);
    }

    public function desasignar(Portafolio $portafolio, string $idProfesion): JsonResponse
    {
        if (!$this->verificarPropietario($portafolio)) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $portafolio->profesiones()->detach($idProfesion);

        return response()->json(['message' => 'Profesión desasignada correctamente.']);
    }
}
