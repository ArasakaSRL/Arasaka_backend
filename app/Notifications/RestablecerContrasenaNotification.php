<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class RestablecerContrasenaNotification extends ResetPassword
{
    public function toMail($notifiable)
    {
        $url = url(config('app.frontend_url') . '/password-reset/' . $this->token . '?email=' . urlencode($notifiable->getEmailForPasswordReset()));

        return (new MailMessage)
            ->subject('Restablecer contraseña - ' . config('app.name'))
            ->greeting('Hola')
            ->line('Recibiste este correo porque se solicitó restablecer tu contraseña.')
            ->action('Restablecer contraseña', $url)
            ->line('Este enlace expira en 60 minutos.')
            ->line('Si no solicitaste esto, ignora este mensaje.');
    }
}
