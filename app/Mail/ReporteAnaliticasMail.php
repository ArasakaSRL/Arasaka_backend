<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ReporteAnaliticasMail extends Mailable
{
    public string $pdfPath;

    public function __construct(string $pdfPath)
    {
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this
            ->subject('Reporte de Analíticas del Portafolio')
            ->view('emails.reporte')
            ->attach($this->pdfPath, [
                'as' => 'reporte-analiticas.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}