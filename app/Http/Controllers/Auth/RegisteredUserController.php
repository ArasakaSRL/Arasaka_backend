<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Portafolio;
use App\Models\Usuario;
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
            'biografia'                 => ['nullable', 'string'],
            'url_foto'                  => ['nullable', 'string', 'url', 'max:500'],
            'estado'                    => ['nullable', 'boolean'],
            'verificacion_email'        => ['nullable', 'date'],
            'portafolio.nombre'         => ['nullable', 'string', 'max:255'],
            'portafolio.descripcion'    => ['nullable', 'string'],
            'portafolio.visibilidad'    => ['nullable', 'boolean'],
        ]);

        $usuario = Usuario::create([
            'nombre'             => $request->nombre,
            'apellido'           => $request->apellido,
            'correo'             => $request->correo,
            'password'           => Hash::make($request->string('password')),
            'biografia'          => $request->biografia,
            'url_foto'           => $request->url_foto,
            'estado'             => $request->estado,
            'verificacion_email' => null,
        ]);

        $portafolioData = $request->input('portafolio', []);
        Portafolio::create([
            'id_portafolio'         => (string) Str::uuid(),
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

        event(new Registered($usuario));

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Auth::login($usuario);

        return response()->noContent();
    }
}
