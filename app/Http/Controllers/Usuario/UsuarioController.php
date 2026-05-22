<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Pais;
use App\Models\Telefono;
use App\Services\Profesion\ProfesionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

use Illuminate\Support\Facades\Hash;

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
            'foto_perfil' => 'required|image|max:500',
        ]);

        //subir a cloudinary
        $result = Cloudinary::uploadApi()->upload($data['foto_perfil']->getRealPath(), [
            'folder' => 'portafolios/usuarios',
            'public_id' => 'foto_' . $request->user()->id_usuario . '_' . time(),
            'overwrite' => true,
        ]);

        $url = $result['secure_url'];
        $publicId = $result['public_id'];

        $request->user()->update([
            'url_foto' => $url,
            'public_id' => $publicId
        ]);

        return response()->json(['message' => 'Foto actualizada correctamente', 'data' => $request->user()->fresh()]);
    }

    // PATCH /usuario/informacion
    public function actualizarInformacion(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombre'    => 'sometimes|required|string|max:50',
            'apellido'  => 'sometimes|required|string|max:50',
            'biografia' => 'sometimes|required|string|max:550',
            'correo'    => 'sometimes|required|email|max:255|unique:usuario,correo,' . $request->user()->id_usuario . ',id_usuario',
            'username'  => 'sometimes|required|string|alpha_num|max:50|unique:usuario,username,' . $request->user()->id_usuario . ',id_usuario',
        ], [
            'correo.unique'   => 'Este correo ya está en uso.',
            'username.unique' => 'Este nombre de usuario ya está en uso.',
            'username.alpha_num' => 'El nombre de usuario solo puede contener letras y números.',
        ]);

        $request->user()->update($data);

        return response()->json(['message' => 'Información actualizada correctamente', 'data' => $request->user()->fresh()]);
    }

    // PATCH /usuario/pais
    public function actualizarPais(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $pais = Pais::updateOrCreate(
            ['id_usuario' => $request->user()->id_usuario],
            ['nombre' => $data['nombre']]
        );

        return response()->json(['message' => 'País actualizado correctamente', 'data' => $pais]);
    }

    // GET /usuario/telefonos
    public function getTelefonos(Request $request): JsonResponse
    {
        return response()->json(['data' => $request->user()->telefonos]);
    }

    // POST /usuario/telefonos
    public function agregarTelefono(Request $request): JsonResponse
    {
        $data = $request->validate([
            'telefono' => 'required|string|max:20',
        ]);

        $telefono = Telefono::create([
            'id_telefono' => (string) \Illuminate\Support\Str::uuid(),
            'id_usuario'  => $request->user()->id_usuario,
            'telefono'    => $data['telefono'],
        ]);

        return response()->json(['message' => 'Teléfono agregado correctamente', 'data' => $telefono], 201);
    }

    // DELETE /usuario/telefonos/{id}
    public function eliminarTelefono(Request $request, string $id): JsonResponse
    {
        $telefono = Telefono::where('id_telefono', $id)
            ->where('id_usuario', $request->user()->id_usuario)
            ->firstOrFail();

        $telefono->delete();

        return response()->json(['message' => 'Teléfono eliminado correctamente']);
    }

    // PATCH /usuario/telefonos/{id}
    public function actualizarTelefono(Request $request, string $id): JsonResponse
    {
        $data = $request->validate([
            'telefono' => 'required|string|max:20',
        ]);

        $telefono = Telefono::where('id_telefono', $id)
            ->where('id_usuario', $request->user()->id_usuario)
            ->firstOrFail();

        $telefono->update($data);

        return response()->json(['message' => 'Teléfono actualizado correctamente', 'data' => $telefono->fresh()]);
    }

    // PATCH /usuario/contrasena
    public function cambiarContrasena(Request $request): JsonResponse
    {
        $data = $request->validate([
            'contrasena_actual' => 'required|string',
            'contrasena_nueva'  => ['required', 'string', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        if (!Hash::check($data['contrasena_actual'], $request->user()->password)) {
            return response()->json(['message' => 'La contraseña actual es incorrecta.'], 422);
        }

        $request->user()->update(['password' => Hash::make($data['contrasena_nueva'])]);

        return response()->json(['message' => 'Contraseña actualizada correctamente']);
    }
}
