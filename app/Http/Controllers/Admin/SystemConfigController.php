<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\SystemConfig;

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
        $config->update($datos);

        return response()->json([
            'success' => true,
            'message' => 'Configuración actualizada correctamente.',
            'data'    => $config,
        ]);
    }
}
