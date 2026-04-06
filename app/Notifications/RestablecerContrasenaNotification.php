<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;

class RestablecerContrasenaNotification extends ResetPassword
{
    public function toMail($notifiable)
    {
        $url = url(config('app.frontend_url') . '/password-reset/' . $this->token . '?email=' . urlencode($notifiable->getEmailForPasswordReset()));

        Mail::raw(
            "Haz clic en el siguiente enlace para restablecer tu contraseña:\n\n" . $url . "\n\nEste enlace expira en 60 minutos.\n\nSi no solicitaste esto, ignora este mensaje.",
            fn($m) => $m
                ->to($notifiable->getEmailForPasswordReset())
                ->subject('Restablecer contraseña - ' . config('app.name'))
        );

        return null;
    }
}
