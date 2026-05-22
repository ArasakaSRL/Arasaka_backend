<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class CodigoVerificacionCorreoNotification extends Notification
{
    public function __construct(private string $codigo, private string $correoNuevo) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        Mail::raw(
            "Tu código de verificación para cambiar tu correo es: {$this->codigo}\n\nEste código expira en 15 minutos.\n\nSi no solicitaste este cambio, ignora este mensaje.",
            fn($m) => $m
                ->to($this->correoNuevo)
                ->subject('Código de verificación - ' . config('app.name'))
        );

        return null;
    }
}
