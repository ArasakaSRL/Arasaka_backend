<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdvertenciaUsuarioNotification extends Notification
{
    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Advertencia - Tu cuenta está en riesgo de suspensión')
            ->greeting('Hola, ' . $notifiable->nombre)
            ->line('Varios de tus portafolios han sido suspendidos por incumplir nuestras políticas.')
            ->line('Tu cuenta está en riesgo de ser suspendida si continúas infringiendo las normas.')
            ->line('Te recomendamos revisar el contenido de tus portafolios.')
            ->salutation('El equipo de ' . config('app.name'));
    }
}
