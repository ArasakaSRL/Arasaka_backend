<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class PasswordResetLinkController extends Controller
{
    /**
     * envia un enlace de restablecimiento de contraseña al correo electrónico del usuario. El usuario debe proporcionar su correo electrónico para recibir el enlace.
     *
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'correo' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            ['correo' => $request->correo]
        );

        if ($status != Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'correo' => [__($status)],
            ]);
        }

        return response()->json(['status' => __($status)]);
    }
}
