<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Notifications\CodigoRegistroNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nombre'                 => ['required', 'string', 'max:255'],
            'apellido'               => ['required', 'string', 'max:255'],
            'correo'                 => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password'               => ['required', 'confirmed', Rules\Password::defaults()],
            'url_foto'               => ['nullable', 'string', 'url', 'max:500'],
            'pais'                   => ['nullable', 'string', 'max:100'],
            'portafolio.nombre'      => ['nullable', 'string', 'max:255'],
            'portafolio.descripcion' => ['nullable', 'string'],
            'portafolio.visibilidad' => ['nullable', 'boolean'],
        ]);

        $usuarioExistente = Usuario::where('correo', $request->correo)->first();

        if ($usuarioExistente && $usuarioExistente->hasVerifiedEmail()) {
            throw ValidationException::withMessages([
                'correo' => ['Este correo ya está en uso.'],
            ]);
        }

        $codigo = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $request->session()->put('registro_pendiente', [
            'nombre'     => $request->nombre,
            'apellido'   => $request->apellido,
            'correo'     => $request->correo,
            'password'   => $request->string('password'),
            'url_foto'   => $request->url_foto,
            'pais'       => $request->input('pais'),
            'portafolio' => $request->input('portafolio', []),
            'codigo'     => $codigo,
            'expira'     => now()->addMinutes(5)->toIso8601String(),
        ]);

        Notification::route('mail', $request->correo)
            ->notify(new CodigoRegistroNotification($codigo, $request->nombre));

        return response()->json([
            'message' => 'Codigo de verificacion enviado a tu correo.',
        ]);
    }
}
