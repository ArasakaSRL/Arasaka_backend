<?php

namespace App\Http\Controllers\Portafolio;

use App\Http\Controllers\Controller;
use App\Models\Portafolio;
use App\Models\Telefono;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PortafolioTelefonoController extends Controller
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

        return response()->json(['data' => $portafolio->telefonos]);
    }

    public function store(Request $request, Portafolio $portafolio): JsonResponse
    {
        if (!$this->verificarPropietario($portafolio)) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $data = $request->validate(['telefono' => 'required|string|max:20']);

        $telefono = Telefono::create([
            'id_telefono'  => (string) Str::uuid(),
            'id_portafolio' => $portafolio->id_portafolio,
            'telefono'     => $data['telefono'],
        ]);

        return response()->json(['message' => 'Teléfono agregado correctamente.', 'data' => $telefono], 201);
    }

    public function update(Request $request, Portafolio $portafolio, string $id): JsonResponse
    {
        if (!$this->verificarPropietario($portafolio)) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $data = $request->validate(['telefono' => 'required|string|max:20']);

        $telefono = Telefono::where('id_telefono', $id)
            ->where('id_portafolio', $portafolio->id_portafolio)
            ->firstOrFail();

        $telefono->update($data);

        return response()->json(['message' => 'Teléfono actualizado correctamente.', 'data' => $telefono->fresh()]);
    }

    public function destroy(Portafolio $portafolio, string $id): JsonResponse
    {
        if (!$this->verificarPropietario($portafolio)) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $telefono = Telefono::where('id_telefono', $id)
            ->where('id_portafolio', $portafolio->id_portafolio)
            ->firstOrFail();

        $telefono->delete();

        return response()->json(['message' => 'Teléfono eliminado correctamente.']);
    }
}
