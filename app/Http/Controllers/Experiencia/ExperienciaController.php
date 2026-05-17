<?php

namespace App\Http\Controllers\Experiencia;

use App\Http\Controllers\Controller;
use App\Http\Requests\experiencia\ExperienciaRequest;
use App\Http\Resources\ExperienciaResource;
use App\Services\Experiencia\ExperienciaService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\experiencia\EliminarExperienciaRequest;
class ExperienciaController extends Controller
{
    protected ExperienciaService $service;

    public function __construct(ExperienciaService $service)
    {
        $this->service = $service;
    }

    private function getPortafolioId()
    {
        return auth()->user()->portafolio->id_portafolio;
    }

    public function index(): JsonResponse
    {
        $data = $this->service->listByPortafolio($this->getPortafolioId());

        return response()->json([
            'data' => ExperienciaResource::collection($data)
        ]);
    }

    public function show(string $id): JsonResponse
    {
        $exp = $this->service->find($id);

        if ($exp->id_portafolio !== $this->getPortafolioId()) {
            abort(403, 'No autorizado');
        }

        return response()->json([
            'data' => new ExperienciaResource($exp)
        ]);
    }

    public function store(ExperienciaRequest $request): JsonResponse
    {
        $exp = $this->service->create(
            $request->validated(),
            $this->getPortafolioId()
        );

        return response()->json([
            'message' => 'Experiencia creada correctamente',
            'data' => new ExperienciaResource($exp)
        ], 201);
    }

    public function update(ExperienciaRequest $request, string $id): JsonResponse
    {
        $exp = $this->service->find($id);

        if ($exp->id_portafolio !== $this->getPortafolioId()) {
            abort(403, 'No autorizado');
        }

        $exp = $this->service->updateModel($exp, $request->validated());

        return response()->json([
            'message' => 'Experiencia actualizada correctamente',
            'data' => new ExperienciaResource($exp)
        ]);
    }
    public function destroyMultiple(EliminarExperienciaRequest $request): JsonResponse
    {
    $totalEliminadas = $this->service->deleteMultiple(
        $request->ids
    );

    return response()->json([
        'message' => 'Experiencias eliminadas correctamente',
        'total_eliminadas' => $totalEliminadas
    ]);
    } 

    public function destroy(string $id): JsonResponse
    {
        $exp = $this->service->find($id);

        if ($exp->id_portafolio !== $this->getPortafolioId()) {
            abort(403, 'No autorizado');
        }

        $this->service->deleteModel($exp);

        return response()->json([
            'message' => 'Experiencia eliminada correctamente'
        ]);
    }
}