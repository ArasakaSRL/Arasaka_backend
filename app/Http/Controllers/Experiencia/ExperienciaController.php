<?php

namespace App\Http\Controllers\Experiencia;

use App\Http\Controllers\Controller;
use App\Http\Requests\experiencia\ExperienciaRequest;
use App\Http\Resources\ExperienciaResource;
use App\Services\Experiencia\ExperienciaService;
use Illuminate\Http\JsonResponse;

class ExperienciaController extends Controller
{
    protected ExperienciaService $service;

    public function __construct(ExperienciaService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => ExperienciaResource::collection($this->service->list())
        ]);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json([
            'data' => new ExperienciaResource($this->service->find($id))
        ]);
    }

    public function store(ExperienciaRequest $request): JsonResponse
    {
        return response()->json([
            'message' => 'Experiencia creada correctamente',
            'data' => new ExperienciaResource($this->service->create($request->validated()))
        ], 201);
    }

    public function update(ExperienciaRequest $request, string $id): JsonResponse
    {
        return response()->json([
            'message' => 'Experiencia actualizada correctamente',
            'data' => new ExperienciaResource($this->service->update($id, $request->validated()))
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json([
            'message' => 'Experiencia eliminada correctamente'
        ]);
    }
    public function byPortafolio(string $portafolioId): JsonResponse
{
    $experiencias = $this->service->getByPortafolio($portafolioId, 'asc');
    return response()->json([
        'data' => ExperienciaResource::collection($experiencias)
    ]);
}
}