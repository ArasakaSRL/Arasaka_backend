<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ConfiguracionPortafolio;
use App\Models\InformacionBasica;
use App\Models\Portafolio;
use App\Models\Usuario;
use App\Models\VisualizacionesPortafolio;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'nombre'                    => ['required', 'string', 'max:255'],
            'apellido'                  => ['required', 'string', 'max:255'],
            'correo'                    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:usuario,correo'],
            'password'                  => ['required', 'confirmed', Rules\Password::defaults()],
            'url_foto'                  => ['nullable', 'string', 'url', 'max:500'],
            'estado'                    => ['nullable', 'boolean'],
            'verificacion_email'        => ['nullable', 'date'],
            'pais'                      => ['nullable', 'string', 'max:100'],
            'portafolio.nombre'         => ['nullable', 'string', 'max:255'],
            'portafolio.descripcion'    => ['nullable', 'string'],
            'portafolio.visibilidad'    => ['nullable', 'boolean'],
        ], [
            'correo.unique' => 'Este correo ya está en uso.',
        ]);

        $username = $this->generarUsername($request->nombre, $request->apellido);

        $usuario = Usuario::create([
            'nombre'             => $request->nombre,
            'apellido'           => $request->apellido,
            'username'           => $username,
            'correo'             => $request->correo,
            'password'           => Hash::make($request->string('password')),
            'url_foto'           => $request->url_foto,
            'estado'             => $request->estado,
            'suspendido'         => false,
            'verificacion_email' => null,
            'tour_completado'    => false,
        ]);

        $portafolioData = $request->input('portafolio', []);
        $idPortafolio = (string) Str::uuid();

        Portafolio::create([
            'id_portafolio'         => $idPortafolio,
            'id_usuario'            => $usuario->id_usuario,
            'nombre'                => $portafolioData['nombre'] ?? $request->nombre . ' ' . $request->apellido,
            'descripcion'           => $portafolioData['descripcion'] ?? null,
            'visibilidad'           => $portafolioData['visibilidad'] ?? true,
            'link_activo'           => true,
            'duracion_link'         => 'sin_limite',
            'fecha_expiracion_link' => null,
            'fecha_creacion'        => now(),
            'fecha_actualizacion'   => now(),
        ]);

        ConfiguracionPortafolio::create([
            'id_portafolio'          => $idPortafolio,
            'mostrar_proyecto'       => true,
            'mostrar_habilidades'    => true,
            'mostrar_experiencia'    => true,
            'mostrar_certificaciones'=> true,
            'mostrar_servicios'      => true,
            'paleta_colores'         => json_encode([
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
            'nombre_completo'       => $request->nombre . ' ' . $request->apellido,
            'gmail'                 => $request->correo,
            'pais'                  => $request->input('pais', ''),
            'foto_perfil'           => $request->url_foto ?? null,
            'biografia'             => $request->biografia ?? null,
        ]);

        event(new Registered($usuario));

        Auth::login($usuario);

        return response()->noContent();
    }

    private function generarUsername(string $nombre, string $apellido): string
    {
        $base = Str::lower(preg_replace('/[^a-z]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $nombre . $apellido)));
        $username = $base;
        $i = 1;

        while (Usuario::where('username', $username)->exists()) {
            $username = $base . $i;
            $i++;
        }

        return $username;
    }
}
