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
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'id_token' => 'required|string',
            'correo'   => 'nullable|string',
            'provider' => 'nullable|string',
        ]);

        try {
            $verifiedToken = Firebase::auth()->verifyIdToken($request->id_token);

            $uid      = $verifiedToken->claims()->get('sub');
            $correo   = $verifiedToken->claims()->get('email') ?? $request->input('correo');
            $nombre   = $verifiedToken->claims()->get('name', '');
            $url_foto = $verifiedToken->claims()->get('picture', null);
            $provider = $request->input('provider');

            $partes   = explode(' ', trim($nombre), 2);
            $nombre   = $partes[0] ?? '';
            $apellido = $partes[1] ?? '';

            if (!$correo) {
                return response()->json([
                    'message' => 'No fue posible obtener el correo electrónico de tu cuenta.'
                ], 422);
            }

            $usuario = Usuario::where('correo', $correo)->first();

            if ($usuario) {
                // Registrado con correo y contraseña
                if ($usuario->password && !$usuario->provider) {
                    return response()->json([
                        'message' => 'Este correo ya está registrado. Inicia sesión con tu contraseña.'
                    ], 409);
                }

                // Registrado con otro proveedor social
                if ($usuario->provider && $usuario->provider !== $provider) {
                    $nombres = [
                        'google.com'   => 'Google',
                        'github.com'   => 'GitHub',
                        'facebook.com' => 'Facebook',
                    ];
                    $nombreProveedor = $nombres[$usuario->provider] ?? $usuario->provider;
                    return response()->json([
                        'message' => "Este correo ya está registrado con {$nombreProveedor}. Inicia sesión con {$nombreProveedor}."
                    ], 409);
                }

                $usuario->update([
                    'firebase_uid' => $uid,
                    'provider'     => $provider,
                    'url_foto'     => $usuario->url_foto ?? $url_foto,
                ]);
            } else {
                $usuario = Usuario::create([
                    'nombre'             => $nombre,
                    'apellido'           => $apellido,
                    'correo'             => $correo,
                    'firebase_uid'       => $uid,
                    'provider'           => $provider,
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
