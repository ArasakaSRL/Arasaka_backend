<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CodigoVerificacionCorreoNotification extends Notification
{
    public function __construct(private string $codigo) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Código de verificación - ' . config('app.name'))
            ->greeting('Hola')
            ->line('Tu código de verificación para cambiar tu correo es:')
            ->line("**{$this->codigo}**")
            ->line('Este código expira en 15 minutos.')
            ->line('Si no solicitaste este cambio, ignora este mensaje.');
    }
}
