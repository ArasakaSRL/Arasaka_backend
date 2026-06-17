<?php

namespace App\Http\Controllers\Portafolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portafolio\ActualizarInformacionBasicaRequest;
use App\Models\Portafolio;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InformacionBasicaController extends Controller
{
    public function actualizar(
        ActualizarInformacionBasicaRequest $request,
        Portafolio $portafolio
    ): JsonResponse {

        if ($portafolio->id_usuario !== auth()->user()->id_usuario) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado.',
            ], 403);
        }

        $portafolio->informacionBasica->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Información básica actualizada correctamente.',
            'data'    => $portafolio->informacionBasica->fresh(),
        ]);
    }

    public function subirFoto(Request $request, Portafolio $portafolio): JsonResponse
    {
        if ($portafolio->id_usuario !== auth()->user()->id_usuario) {
            return response()->json(['success' => false, 'message' => 'No autorizado.'], 403);
        }

        $request->validate(['foto' => 'required|image|max:2048']);

        $result = Cloudinary::uploadApi()->upload($request->file('foto')->getRealPath(), [
            'folder'     => 'portafolios/informacion_basica',
            'public_id'  => 'foto_portafolio_' . $portafolio->id_portafolio . '_' . time(),
            'overwrite'  => true,
        ]);

        $url      = $result['secure_url'];
        $publicId = $result['public_id'];

        $portafolio->informacionBasica->update([
            'foto_perfil'           => $url,
            'foto_perfil_public_id' => $publicId,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Foto de portafolio actualizada correctamente.',
            'data'    => [
                'foto_perfil'           => $url,
                'foto_perfil_public_id' => $publicId,
            ],
        ]);
    }
}
