<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\CodigoVerificacionCorreo;
use App\Models\Usuario;
use App\Notifications\CodigoVerificacionCorreoNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class CambiarCorreoController extends Controller
{
    // POST /usuario/correo/verificar
    public function verificar(Request $request): JsonResponse
    {
        $data = $request->validate([
            'correo_nuevo' => 'required|email|max:255|unique:usuario,correo',
        ], [
            'correo_nuevo.unique' => 'Este correo ya está en uso.',
        ]);

        // Eliminar códigos anteriores del usuario
        CodigoVerificacionCorreo::where('id_usuario', $request->user()->id_usuario)->delete();

        $codigo = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        CodigoVerificacionCorreo::create([
            'id_usuario'  => $request->user()->id_usuario,
            'correo_nuevo' => $data['correo_nuevo'],
            'codigo'      => $codigo,
            'expira_en'   => now()->addMinutes(15),
        ]);

        Notification::route('mail', $data['correo_nuevo'])
            ->notify(new CodigoVerificacionCorreoNotification($codigo));

        return response()->json(['message' => 'Código enviado al nuevo correo.']);
    }

    // POST /usuario/correo/confirmar
    public function confirmar(Request $request): JsonResponse
    {
        $data = $request->validate([
            'correo_nuevo' => 'required|email',
            'codigo'       => 'required|string|size:6',
        ]);

        $registro = CodigoVerificacionCorreo::where('id_usuario', $request->user()->id_usuario)
            ->where('correo_nuevo', $data['correo_nuevo'])
            ->where('codigo', $data['codigo'])
            ->first();

        if (!$registro) {
            return response()->json(['message' => 'Código incorrecto.'], 422);
        }

        if ($registro->expira_en->isPast()) {
            $registro->delete();
            return response()->json([
                'message' => 'El código ha expirado.'], 422);
        }

        $request->user()->update([
            'correo'       => $data['correo_nuevo'],
            'firebase_uid' => null,
            'provider'     => null,
        ]);
        $registro->delete();

        return response()->json(['message' => 'Correo actualizado correctamente.']);
    }
}
