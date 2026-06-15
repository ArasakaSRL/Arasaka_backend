<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\CodigoRegistroNotification;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ReenviarCodigoRegistroController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate(['correo' => ['required', 'email']]);

        $pendiente = $request->session()->get('registro_pendiente');

        if (!$pendiente || $pendiente['correo'] !== $request->correo) {
            return response()->json(['message' => 'No hay un registro pendiente para este correo.'], 422);
        }

        $codigo = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $pendiente['codigo'] = $codigo;
        $pendiente['expira'] = now()->addMinutes(5)->toIso8601String();

        $request->session()->put('registro_pendiente', $pendiente);

        Notification::route('mail', $pendiente['correo'])
            ->notify(new CodigoRegistroNotification($codigo, $pendiente['nombre']));

        return response()->json(['message' => 'Código reenviado a tu correo.']);
    }
}
