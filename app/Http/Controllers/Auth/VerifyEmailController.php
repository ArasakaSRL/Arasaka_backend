<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Verifica el correo electrónico del usuario cuando hace clic en el enlace de verificación.
     * No requiere que el usuario esté autenticado — la URL firmada valida la solicitud.
     */
    public function __invoke(string $id, string $hash): RedirectResponse
    {
        $usuario = Usuario::findOrFail($id);

        if (!hash_equals(sha1($usuario->getEmailForVerification()), $hash)) {
            return redirect(config('app.frontend_url') . '/verificacion-fallida');
        }

        if ($usuario->hasVerifiedEmail()) {
            return redirect(config('app.frontend_url') . '/dashboard?verified=1');
        }

        if ($usuario->markEmailAsVerified()) {
            event(new Verified($usuario));
        }

        return redirect(config('app.frontend_url') . '/dashboard?verified=1');
    }
}
