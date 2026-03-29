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
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'correo' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            ['email' => $request->correo]
        );

        if ($status != Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'correo' => [__($status)],
            ]);
        }

        return response()->json(['status' => __($status)]);
    }
}
