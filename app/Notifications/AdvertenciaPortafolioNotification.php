<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdvertenciaPortafolioNotification extends Notification
{
    public function __construct(
        protected string $nombrePortafolio
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Advertencia - Tu portafolio está en riesgo de suspensión')
            ->greeting('Hola, ' . $notifiable->nombre)
            ->line('Tu portafolio "' . $this->nombrePortafolio . '" ha acumulado varias denuncias.')
            ->line('Tu portafolio ha recibido varias denuncias y está en riesgo de ser suspendido.')
            ->line('Te recomendamos revisar el contenido de tu portafolio para asegurarte de que cumple con nuestras políticas.')
            ->salutation('El equipo de ' . config('app.name'));
    }
}
