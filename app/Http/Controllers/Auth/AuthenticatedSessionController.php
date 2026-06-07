<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        if ($request->hasSession()) {
            $request->session()->regenerate();
        }

        /** @var Usuario $user */
        $user = Auth::user();

        if ($user->suspendido && $user->suspendido_hasta?->isFuture()) {
            Auth::guard('web')->logout();
            return response()->json([
                'suspended'       => true,
                'message'         => 'Tu cuenta está suspendida.',
                'suspendido_hasta' => $user->suspendido_hasta->toIso8601String(),
            ], 403);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => $user,
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }

        return response()->noContent();
    }
}
