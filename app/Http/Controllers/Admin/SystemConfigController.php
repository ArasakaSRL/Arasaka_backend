<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Controller;
use App\Models\SystemConfig;
use App\Models\Usuario;
use App\Notifications\ConfiguracionActualizadaNotification;

class SystemConfigController extends Controller
{
    public function show(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => SystemConfig::get(),
        ]);
    }

    public function update(): JsonResponse
    {
        $datos = request()->validate([
            'denuncias_advertencia'      => 'required|integer|min:1',
            'denuncias_suspension'       => 'required|integer|min:1',
            'portafolios_advertencia'    => 'required|integer|min:1',
            'portafolios_suspension'     => 'required|integer|min:1',
            'dias_suspension_portafolio' => 'required|integer|min:1',
            'dias_suspension_usuario'    => 'required|integer|min:1',
        ]);

        $config = SystemConfig::get();

        $campos = [
            'denuncias_advertencia', 'denuncias_suspension',
            'portafolios_advertencia', 'portafolios_suspension',
            'dias_suspension_portafolio', 'dias_suspension_usuario',
        ];

        $cambios = [];
        foreach ($campos as $campo) {
            if ((int) $config->$campo !== (int) $datos[$campo]) {
                $cambios[$campo] = ['antes' => $config->$campo, 'despues' => $datos[$campo]];
            }
        }

        $config->update($datos);

        if (!empty($cambios)) {
            $usuarios = Usuario::where('rol', 'user')->where('estado', true)->get();
            Notification::send($usuarios, new ConfiguracionActualizadaNotification($cambios));
        }

        return response()->json([
            'success' => true,
            'message' => 'Configuración actualizada correctamente.',
            'data'    => $config,
        ]);
    }
}
