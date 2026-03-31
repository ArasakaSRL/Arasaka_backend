<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Services\Profesion\ProfesionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function __construct(protected ProfesionService $profesionService) {}

    // GET /usuario/profesiones
    public function getProfesiones(Request $request): JsonResponse
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $profesiones = $this->profesionService->getProfesionesDeUsuario($user);
        $profesiones->makeHidden('pivot');
        return response()->json(['data' => $profesiones]);
    }

    // POST /usuario/profesiones
    public function asignarProfesion(Request $request): JsonResponse
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $data = $request->validate([
            'id_profesion' => 'required|string|uuid',
        ]);

        $this->profesionService->asignarProfesion($user, $data['id_profesion']);

        return response()->json(['message' => 'Profesión asignada correctamente'], 201);
    }

    // DELETE /usuario/profesiones/{id}
    public function desasignarProfesion(Request $request, string $id): JsonResponse
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $this->profesionService->desasignarProfesion($user, $id);

        return response()->json(['message' => 'Profesión desasignada correctamente']);
    }

    // PATCH /usuario/biografia
    // public function actualizarBiografia(Request $request): JsonResponse
    // {
    //     $data = $request->validate([
    //         'biografia' => 'required|string|max:550',
    //     ]);

    //     $request->user()->update(['biografia' => $data['biografia']]);

    //     return response()->json(['message' => 'Biografía actualizada correctamente', 'data' => $request->user()->fresh()]);
    // }

    // PATCH /usuario/foto
    public function actualizarFoto(Request $request): JsonResponse
    {
        $data = $request->validate([
            'url_foto' => 'required|url|max:500',
        ]);

        $request->user()->update(['url_foto' => $data['url_foto']]);

        return response()->json(['message' => 'Foto actualizada correctamente', 'data' => $request->user()->fresh()]);
    }

    // PATCH /usuario/informacion
    public function actualizarInformacion(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombre'   => 'sometimes|required|string|max:50',
            'apellido' => 'sometimes|required|string|max:50',
            'descripcion_laboral'=> 'sometimes|required|string|max:550',
            'correo'    =>'sometimes|required|email|max:255',
        ]);

        $request->user()->update($data);

        return response()->json(['message' => 'Información actualizada correctamente', 'data' => $request->user()->fresh()]);
    }

}
