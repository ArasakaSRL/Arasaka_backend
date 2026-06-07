<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SuspensionPortafolioNotification extends Notification
{
    public function __construct(
        protected string $nombrePortafolio,
        protected Carbon $suspendidoHasta
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Tu portafolio ha sido suspendido - Arasaka SRL')
            ->greeting('Hola, ' . $notifiable->nombre)
            ->line('Tu portafolio "' . $this->nombrePortafolio . '" ha sido suspendido por acumular demasiadas denuncias.')
            ->line('El portafolio ya no es visible para otros usuarios hasta el ' . $this->suspendidoHasta->format('d/m/Y') . '.')
            ->line('Si crees que esto es un error, puedes contactar a nuestro equipo de soporte.')
            ->salutation('El equipo de ' . config('app.name'));
    }
}
