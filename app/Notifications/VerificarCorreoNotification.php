<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerificarCorreoNotification extends VerifyEmail
{
    public function toMail($notifiable)
    {
        $url = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verifica tu correo - ' . config('app.name'))
            ->greeting('Hola')
            ->line('Haz clic en el siguiente botón para verificar tu correo:')
            ->action('Verificar correo', $url)
            ->line('Si no creaste una cuenta, ignora este mensaje.');
    }
}
