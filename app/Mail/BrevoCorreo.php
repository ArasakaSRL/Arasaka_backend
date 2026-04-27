<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class BrevoCorreo extends Mailable
{
    public function __construct(
        public string $remitente,
        public string $nombreRemitente,
        public string $asunto,
        public string $contenido,
        public array $archivos = [],
    ) {}

    public function build()
    {
        $mail = $this->from(env('BREVO_FROM_ADDRESS'), env('BREVO_FROM_NAME'))
                    ->replyTo($this->remitente, $this->nombreRemitente)
                    ->subject($this->nombreRemitente . ' te envió un mensaje')
                    ->view('emails.personalizado')
                    ->with([
                        'subject'         => $this->asunto,
                        'content'         => $this->contenido,
                        'nombreRemitente' => $this->nombreRemitente,
                        'correoRemitente' => $this->remitente,
                    ]);

        foreach ($this->archivos as $archivo) {
            $mail->attach($archivo->getRealPath(), [
                'as'   => $archivo->getClientOriginalName(),
                'mime' => $archivo->getMimeType(),
            ]);
        }

        return $mail;
    }
}
