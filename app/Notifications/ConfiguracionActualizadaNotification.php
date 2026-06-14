<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;

class ConfiguracionActualizadaNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected array $cambios) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $etiquetas = [
            'denuncias_advertencia'      => 'Denuncias para advertir portafolio',
            'denuncias_suspension'       => 'Denuncias para suspender portafolio',
            'portafolios_advertencia'    => 'Portafolios suspendidos para advertir usuario',
            'portafolios_suspension'     => 'Portafolios suspendidos para suspender usuario',
            'dias_suspension_portafolio' => 'Dias de suspension de portafolio',
            'dias_suspension_usuario'    => 'Dias de suspension de usuario',
        ];

        $mail = (new MailMessage)
            ->subject('Actualizacion de politicas de moderacion - ' . config('app.name'))
            ->greeting('Hola, ' . $notifiable->nombre)
            ->line('Los limites de moderacion de la plataforma han sido actualizados. A continuacion se detallan los cambios:');

        foreach ($this->cambios as $campo => $valores) {
            $nombre = $etiquetas[$campo] ?? $campo;
            $mail->line("{$nombre}: {$valores['antes']} -> {$valores['despues']}");
        }

        return $mail
            ->line('Estos cambios aplican inmediatamente para las proximas denuncias.')
            ->salutation('El equipo de ' . config('app.name'));
    }
}
