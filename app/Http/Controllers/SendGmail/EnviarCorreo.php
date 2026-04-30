<?php

namespace App\Http\Controllers\SendGmail;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\NotificacionPersonalizada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class EnviarCorreo extends Controller
{
    public function enviarCorreo(Request $request)
    {
        $request->validate([
            'to' => 'required|email',
            'from' => 'required|email',
            'subject' => 'required|string',
            'content' => 'required|string',
        ]);

        // Puedes notificar a un usuario existente o usar "AnonymousNotifiable"
        Notification::route('mail', $request->to)
            ->notify(new NotificacionPersonalizada(
                $request->from,
                $request->subject,
                $request->content
            ));

        return response()->json([
            'message' => 'Correo enviado correctamente'
        ]);
    }
}
