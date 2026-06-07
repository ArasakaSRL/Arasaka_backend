<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\DenunciaPortafolio;
use App\Models\Portafolio;
use App\Models\Usuario;

class DenunciaAdminController extends Controller
{
    public function denuncias(): JsonResponse
    {
        $denuncias = DenunciaPortafolio::with([
            'portafolio.usuario',
            'etiqueta',
        ])
        ->latest()
        ->paginate(20);

        return response()->json([
            'success' => true,
            'data'    => $denuncias,
        ]);
    }

    public function portafoliosSuspendidos(): JsonResponse
    {
        $portafolios = Portafolio::where('suspendido', true)
            ->with(['usuario', 'denuncias.etiqueta'])
            ->latest('fecha_actualizacion')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $portafolios,
        ]);
    }

    public function usuariosSuspendidos(): JsonResponse
    {
        $usuarios = Usuario::where('suspendido', true)
            ->with(['portafolios' => fn($q) => $q->where('suspendido', true)])
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $usuarios,
        ]);
    }
}
