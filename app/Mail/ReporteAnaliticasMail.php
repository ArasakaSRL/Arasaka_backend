<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReporteAnaliticasMail extends Mailable
{
    use Queueable, SerializesModels;

    public $portafolio;
    protected $pdfData;
    protected $fileName;

    /**
     * Crear una nueva instancia del mensaje.
     */
    public function __construct($portafolio, $pdfData, $fileName)
    {
        $this->portafolio = $portafolio;
        $this->pdfData = $pdfData;
        $this->fileName = $fileName;
    }

    /**
     * Definir el asunto y forzar el remitente configurado de tu servicio de correos (Brevo/Gmail).
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                env('BREVO_FROM_ADDRESS', 'arasakasrl@gmail.com'), 
                env('BREVO_FROM_NAME', 'Arasaka-SRL')
            ),
            subject: 'Reporte Analítico de Portafolio - ' . ($this->portafolio->nombre ?? $this->portafolio->slug),
        );
    }

    /**
     * Vincular la vista del cuerpo del correo.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reporte_notificacion',
        );
    }

    /**
     * Adjuntar el archivo PDF generado en memoria (Evita llenar el disco de basura).
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->pdfData, $this->fileName)
                ->withMime('application/pdf'),
        ];
    }
}