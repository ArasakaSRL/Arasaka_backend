<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NotificacionPersonalizada extends Notification
{
    protected $from;
    protected $subject;
    protected $content;

    // Constructor para inicializar los datos de la notificación
    public function __construct($from, $subject, $content)
    {
        $this->from = $from;
        $this->subject = $subject;
        $this->content = $content;
    }

    // Especifica los canales a través de los cuales se enviará la notificación
    public function via($notifiable)
    {
        return ['mail'];
    }

    // Configura el mensaje de correo electrónico que se enviará
    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->from($this->from)
            ->subject($this->subject)
            ->view('emails.personalizado', [
                'from' => $this->from,
                'content' => $this->content,
            ]);
    }
}