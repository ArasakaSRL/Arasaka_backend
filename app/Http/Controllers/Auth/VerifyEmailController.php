<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * sirve para verificar el correo electrónico del usuario cuando hace clic en el enlace de verificación enviado a su correo.
      * El enlace de verificación contiene un token que se utiliza para validar la solicitud.
      * Si la verificación es exitosa, se marca el correo electrónico del usuario como verificado y se redirige al frontend con un parámetro indicando que la verificación fue exitosa.
      * Si el correo ya ha sido verificado, simplemente redirige al frontend sin realizar ninguna acción adicional
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(
                config('app.frontend_url').'/dashboard?verified=1'
            );
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(
            config('app.frontend_url').'/dashboard?verified=1'
        );
    }
}
