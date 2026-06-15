<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CodigoRegistroNotification extends Notification
{
    public function __construct(private string $codigo, private string $nombre = '') {}

    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Codigo de verificacion - ' . config('app.name'))
            ->greeting('Hola, ' . $this->nombre)
            ->line('Tu codigo de verificacion para completar el registro es:')
            ->line("**{$this->codigo}**")
            ->line('Este codigo expira en 5 minutos.')
            ->line('Si no creaste una cuenta, ignora este mensaje.')
            ->salutation('El equipo de ' . config('app.name'));
    }
}
