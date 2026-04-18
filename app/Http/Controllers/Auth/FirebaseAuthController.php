<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FirebaseAuthController extends Controller
{

/**
 * funcionando con el id_token que se obtiene del cliente después de iniciar sesión
 *  con Firebase Authentication. El controlador verifica el token, extrae la información
 *  del usuario y luego crea o actualiza un registro en la base de datos para ese usuario.
 *  Finalmente, inicia sesión al usuario en la aplicación Laravel y devuelve una respuesta
 *  JSON indicando que la sesión se ha iniciado correctamente. Si el token es inválido,
 *  devuelve una respuesta de error.
 */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'id_token' => 'required|string',
        ]);

        try {
            $auth = Firebase::auth();
            $verifiedToken = $auth->verifyIdToken($request->id_token);

            $uid        = $verifiedToken->claims()->get('sub');
            $correo     = $verifiedToken->claims()->get('email');
            $nombre     = $verifiedToken->claims()->get('name', '');
            $url_foto   = $verifiedToken->claims()->get('picture', null);

            $partes  = explode(' ', trim($nombre), 2);
            $nombre  = $partes[0] ?? '';
            $apellido = $partes[1] ?? '';

            $usuario = Usuario::where('firebase_uid', $uid)->first();

            if (!$usuario) {
                $usuarioPorCorreo = Usuario::where('correo', $correo)->first();

                if ($usuarioPorCorreo && $usuarioPorCorreo->firebase_uid && $usuarioPorCorreo->firebase_uid !== $uid) {
                    return response()->json([
                        'message' => 'Este correo ya está registrado con otro proveedor de autenticación.'
                    ], 409);
                }

                $usuario = $usuarioPorCorreo;
            }

            // Si el usuario existe pero no tiene un firebase_uid, lo actualizamos. Si no existe, lo creamos.
            if ($usuario) {
                $usuario->update([
                    'firebase_uid' => $uid,
                    'url_foto'     => $usuario->url_foto ?? $url_foto,
                ]);
            } else {
                $usuario = Usuario::create([
                    'nombre'             => $nombre,
                    'apellido'           => $apellido,
                    'correo'             => $correo,
                    'firebase_uid'       => $uid,
                    'url_foto'           => $url_foto,
                    'verificacion_email' => now(),
                    'estado'             => true,
                ]);
            }

            Auth::login($usuario);
            $request->session()->regenerate();

            return response()->json(['message' => 'Sesión iniciada correctamente']);

        } catch (\Throwable $e) {
            return response()->json(['message' => 'Token inválido', 'error' => $e->getMessage()], 401);
        }
    }
}
