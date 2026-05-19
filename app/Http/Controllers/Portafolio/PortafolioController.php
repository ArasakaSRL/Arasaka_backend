<?php

namespace App\Http\Controllers\Portafolio;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Models\Portafolio;
use App\Http\Controllers\Controller;
use App\Services\Portafolio\PortafolioService;
use App\Http\Resources\Portafolio\PortafolioResource;
use App\Http\Requests\Portafolio\CrearPortafolioRequest;
use App\Http\Requests\Portafolio\ActualizarPortafolioRequest;

class PortafolioController extends Controller
{
    public function __construct(
        protected PortafolioService $service
    ) {}

    public function listar(): JsonResponse
    {
        $portafolios = Portafolio::where(
            'id_usuario',
            auth()->user()->id_usuario
        )
        ->with([
            'configuracion',
            'visualizaciones',
        ])
        ->latest('fecha_creacion')
        ->get();

        return response()->json([
            'success' => true,
            'message' =>
                'Portafolios obtenidos correctamente.',

            'data' =>
                PortafolioResource::collection(
                    $portafolios
                ),
        ]);
    }

    public function crear(
        CrearPortafolioRequest $request
    ): JsonResponse {

        try {

            $portafolio = $this->service->crear(
                $request->validated(),
                auth()->user()->id_usuario
            );

            return response()->json([
                'success' => true,
                'message' =>
                    'Portafolio creado correctamente.',

                'data' =>
                    new PortafolioResource($portafolio),
            ], 201);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Error al crear el portafolio.',

                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function mostrar(
        Portafolio $portafolio
    ): JsonResponse {

        if (
            $portafolio->id_usuario !==
            auth()->user()->id_usuario
        ) {

            return response()->json([
                'success' => false,
                'message' => 'No autorizado.',
            ], 403);
        }

        return response()->json([
            'success' => true,

            'data' => new PortafolioResource(
                $portafolio->load([
                    'configuracion',
                    'visualizaciones',
                ])
            ),
        ]);
    }

    public function actualizar(
        ActualizarPortafolioRequest $request,
        Portafolio $portafolio
    ): JsonResponse {

        if (
            $portafolio->id_usuario !==
            auth()->user()->id_usuario
        ) {

            return response()->json([
                'success' => false,
                'message' => 'No autorizado.',
            ], 403);
        }

        $portafolioActualizado = $this->service
            ->actualizar(
                $portafolio,
                $request->validated()
            );

        return response()->json([
            'success' => true,

            'message' =>
                'Portafolio actualizado correctamente.',

            'data' =>
                new PortafolioResource(
                    $portafolioActualizado
                ),
        ]);
    }

    public function eliminar(
        Portafolio $portafolio
    ): JsonResponse {

        if (
            $portafolio->id_usuario !==
            auth()->user()->id_usuario
        ) {

            return response()->json([
                'success' => false,
                'message' => 'No autorizado.',
            ], 403);
        }

        $this->service->eliminar($portafolio);

        return response()->json([
            'success' => true,

            'message' =>
                'Portafolio eliminado correctamente.',
        ]);
    }
}