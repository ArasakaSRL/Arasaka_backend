<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class NewPasswordController extends Controller
{
    /**
     * funciona para restablecer la contraseña de un usuario. 
     * El usuario debe proporcionar un token válido,
     * su correo electrónico y la nueva contraseña que desea establecer.
     * Si el token es válido y el correo electrónico coincide con el token, 
     * se actualiza la contraseña del usuario en la base de datos y se marca el token como utilizado. 
     * Si el proceso es exitoso, se devuelve una respuesta JSON indicando que la contraseña ha sido
     * restablecida correctamente. Si hay algún error, se lanza una excepción de validación
     * con el mensaje correspondiente.
     *
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'token'    => ['required'],
            'correo'   => ['required', 'email'], // Validamos tu campo 'correo'
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            [
                'token'    => $request->token,
                'correo'   => $request->correo,
                'email'    => $request->correo,
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'correo' => [__($status)], // Cambiado a 'correo' para tu front
            ]);
        }

        return response()->json(['status' => __($status)]);
    }
}
