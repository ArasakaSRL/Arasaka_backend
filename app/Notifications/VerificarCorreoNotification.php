<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Mail;

class VerificarCorreoNotification extends VerifyEmail
{
    public function toMail($notifiable)
    {
        $url = $this->verificationUrl($notifiable);

        Mail::raw(
            "Haz clic en el siguiente enlace para verificar tu correo:\n\n" . $url . "\n\nSi no creaste una cuenta, ignora este mensaje.",
            fn($m) => $m
                ->to($notifiable->getEmailForVerification())
                ->subject('Verifica tu correo - ' . config('app.name'))
        );

        return null;
    }
}
