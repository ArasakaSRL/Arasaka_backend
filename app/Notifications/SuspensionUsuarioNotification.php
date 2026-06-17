<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SuspensionUsuarioNotification extends Notification
{
    public function __construct(
        protected Carbon $suspendidoHasta
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Tu cuenta ha sido suspendida - Arasaka SRL')
            ->greeting('Hola, ' . $notifiable->nombre)
            ->line('Tu cuenta ha sido suspendida porque varios de tus portafolios fueron suspendidos por incumplir nuestras políticas.')
            ->line('Tu acceso a la plataforma estará restringido hasta el ' . $this->suspendidoHasta->format('d/m/Y') . '.')
            ->line('Si crees que esto es un error, puedes contactar a nuestro equipo de soporte.')
            ->salutation('El equipo de ' . config('app.name'));
    }
}
