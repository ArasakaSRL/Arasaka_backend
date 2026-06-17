<?php

namespace App\Http\Controllers\Portafolio;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\DenunciaPortafolio;
use App\Models\EtiquetaDenuncia;
use App\Models\Portafolio;
use App\Services\SuspensionService;

class DenunciarPortafolioController extends Controller
{
    public function __construct(
        protected SuspensionService $suspensionService
    ) {}

    public function etiquetas(): JsonResponse
    {
        $etiquetas = EtiquetaDenuncia::all();

        return response()->json([
            'success' => true,
            'data'    => $etiquetas,
        ]);
    }

    public function store(Portafolio $portafolio): JsonResponse
    {
        if ($portafolio->suspendido) {
            return response()->json([
                'success' => false,
                'message' => 'Este portafolio acaba de ser suspendido y ya no acepta denuncias.',
            ], 422);
        }

        $datos = request()->validate([
            'id_etiqueta_denuncia' => 'required|exists:etiqueta_denuncia,id_etiqueta_denuncia',
            'motivo'               => 'nullable|string|max:500',
        ]);

        DenunciaPortafolio::create([
            'id_portafolio'        => $portafolio->id_portafolio,
            'id_etiqueta_denuncia' => $datos['id_etiqueta_denuncia'],
            'motivo'               => $datos['motivo'] ?? null,
        ]);

        $this->suspensionService->evaluarPortafolio($portafolio->fresh());

        return response()->json([
            'success' => true,
            'message' => 'Denuncia enviada correctamente.',
        ], 201);
    }
}
