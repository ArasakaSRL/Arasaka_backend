<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ConfiguracionPortafolio;
use App\Models\InformacionBasica;
use App\Models\Portafolio;
use App\Models\Usuario;
use App\Models\VisualizacionesPortafolio;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VerificarCodigoRegistroController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'correo' => ['required', 'email'],
            'codigo' => ['required', 'string', 'size:6'],
        ]);

        $pendiente = $request->session()->get('registro_pendiente');

        if (!$pendiente || $pendiente['correo'] !== $request->correo) {
            return response()->json(['message' => 'No hay un registro pendiente para este correo.'], 422);
        }

        if ($pendiente['codigo'] !== $request->codigo) {
            return response()->json(['message' => 'Codigo incorrecto.'], 422);
        }

        if (Carbon::parse($pendiente['expira'])->isPast()) {
            $request->session()->forget('registro_pendiente');
            return response()->json(['message' => 'El codigo ha expirado. Vuelve a registrarte.'], 422);
        }

        $usuario = DB::transaction(function () use ($pendiente) {
            $username = $this->generarUsername($pendiente['nombre'], $pendiente['apellido']);

            $usuario = Usuario::create([
                'nombre'             => $pendiente['nombre'],
                'apellido'           => $pendiente['apellido'],
                'username'           => $username,
                'correo'             => $pendiente['correo'],
                'password'           => Hash::make($pendiente['password']),
                'url_foto'           => $pendiente['url_foto'] ?? null,
                'estado'             => true,
                'rol'                => 'user',
                'suspendido'         => false,
                'verificacion_email' => now(),
                'tour_completado'    => false,
            ]);

            $portafolioData = $pendiente['portafolio'] ?? [];
            $idPortafolio   = (string) Str::uuid();

            Portafolio::create([
                'id_portafolio'         => $idPortafolio,
                'id_usuario'            => $usuario->id_usuario,
                'nombre'                => $portafolioData['nombre'] ?? $pendiente['nombre'] . ' ' . $pendiente['apellido'],
                'descripcion'           => $portafolioData['descripcion'] ?? null,
                'visibilidad'           => $portafolioData['visibilidad'] ?? true,
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
                'nombre_completo'       => $pendiente['nombre'] . ' ' . $pendiente['apellido'],
                'gmail'                 => $pendiente['correo'],
                'pais'                  => $pendiente['pais'] ?? '',
                'foto_perfil'           => $pendiente['url_foto'] ?? null,
                'biografia'             => null,
            ]);

            return $usuario;
        });

        $request->session()->forget('registro_pendiente');

        Auth::login($usuario);
        $request->session()->regenerate();

        return response()->json(['message' => 'Correo verificado. Bienvenido a ' . config('app.name') . '.']);
    }

    private function generarUsername(string $nombre, string $apellido): string
    {
        $base     = Str::lower(preg_replace('/[^a-z]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $nombre . $apellido)));
        $username = $base;
        $i        = 1;

        while (Usuario::where('username', $username)->exists()) {
            $username = $base . $i;
            $i++;
        }

        return $username;
    }
}
