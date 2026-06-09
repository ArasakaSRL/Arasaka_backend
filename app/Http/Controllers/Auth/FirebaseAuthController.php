<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ConfiguracionPortafolio;
use App\Models\InformacionBasica;
use App\Models\Portafolio;
use App\Models\Usuario;
use App\Models\VisualizacionesPortafolio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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
                    'username'           => null,
                    'correo'             => $correo,
                    'password'           => null,
                    'firebase_uid'       => $uid,
                    'provider'           => $provider,
                    'url_foto'           => $url_foto,
                    'verificacion_email' => now(),
                    'estado'             => true,
                    'rol'                => 'user',
                    'suspendido'         => false,
                ]);
                $idPortafolio = (string) Str::uuid();

                Portafolio::create([
                    'id_portafolio'         => $idPortafolio,
                    'id_usuario'            => $usuario->id_usuario,
                    'nombre'                => trim($nombre . ' ' . $apellido),
                    'visibilidad'           => true,
                    'link_activo'           => true,
                    'duracion_link'         => 'sin_limite',
                    'fecha_expiracion_link' => null,
                    'fecha_creacion'        => now(),
                    'fecha_actualizacion'   => now(),
                ]);

                ConfiguracionPortafolio::create([
                    'id_portafolio'           => $idPortafolio,
                    'mostrar_proyecto'        => true,
                    'mostrar_habilidades'     => true,
                    'mostrar_experiencia'     => true,
                    'mostrar_certificaciones' => true,
                    'mostrar_servicios'       => true,
                    'paleta_colores'          => json_encode([
                        'primary'   => '#000000',
                        'secondary' => '#ffffff',
                    ]),
                ]);

                VisualizacionesPortafolio::create([
                    'id_portafolio' => $idPortafolio,
                    'fecha'         => now()->toDateString(),
                ]);

                InformacionBasica::create([
                    'id_informacion_basica' => (string) Str::uuid(),
                    'id_portafolio'         => $idPortafolio,
                    'nombre_completo'       => trim($nombre . ' ' . $apellido),
                    'gmail'                 => $correo,
                    'pais'                  => null,
                    'foto_perfil'           => $url_foto,
                    'biografia'             => null,
                ]);
            }

            if ($usuario->suspendido && $usuario->suspendido_hasta?->isFuture()) {
                return response()->json([
                    'suspended'        => true,
                    'message'          => 'Tu cuenta está suspendida.',
                    'suspendido_hasta' => $usuario->suspendido_hasta->toIso8601String(),
                ], 403);
            }

            Auth::login($usuario);
            $request->session()->regenerate();

            return response()->json(['message' => 'Sesión iniciada correctamente']);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Token inválido', 'error' => $e->getMessage()], 401);
        }
    }
}
