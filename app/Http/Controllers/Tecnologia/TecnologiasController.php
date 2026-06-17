<?php

namespace App\Http\Controllers\Tecnologia;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tecnologia\TecnologiaRequest;
use App\Http\Resources\Tecnologia\TecnologiaResource;
use App\Services\Tecnologia\TecnologiaService;
use Illuminate\Http\JsonResponse;

class TecnologiasController extends Controller
{
    protected TecnologiaService $service;

    public function __construct(TecnologiaService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $tecnologias = $this->service->listar(9);
        

        return response()->json([
            'success' => true,
            'message' => 'Listado de tecnologías obtenido correctamente.',
            'data' => TecnologiaResource::collection($tecnologias),
            'pagination' => [
                'current_page' => $tecnologias->currentPage(),
                'last_page' => $tecnologias->lastPage(),
                'per_page' => $tecnologias->perPage(),
                'total' => $tecnologias->total(),
            ]
        ], 200);
    }

    public function store(TecnologiaRequest $request): JsonResponse
    {
        $tecnologias = $this->service->crear($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Tecnología creada correctamente.',
            'data' => TecnologiaResource::collection($tecnologias),
            'pagination' => [
                'current_page' => $tecnologias->currentPage(),
                'last_page' => $tecnologias->lastPage(),
                'per_page' => $tecnologias->perPage(),
                'total' => $tecnologias->total(),
            ]
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $tecnologia = $this->service->mostrar($id);

        return response()->json([
            'success' => true,
            'message' => 'Tecnología encontrada correctamente.',
            'data' => new TecnologiaResource($tecnologia)
        ], 200);
    }

    public function update(TecnologiaRequest $request, string $id): JsonResponse
    {
        $tecnologias = $this->service->actualizar($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Tecnología actualizada correctamente.',
            'data' => TecnologiaResource::collection($tecnologias),
            'pagination' => [
                'current_page' => $tecnologias->currentPage(),
                'last_page' => $tecnologias->lastPage(),
                'per_page' => $tecnologias->perPage(),
                'total' => $tecnologias->total(),
            ]
        ], 200);
    }

    public function destroy(string $id): JsonResponse
    {
        $tecnologias = $this->service->eliminar($id);

        return response()->json([
            'success' => true,
            'message' => 'Tecnología eliminada correctamente.',
            'data' => TecnologiaResource::collection($tecnologias),
            'pagination' => [
                'current_page' => $tecnologias->currentPage(),
                'last_page' => $tecnologias->lastPage(),
                'per_page' => $tecnologias->perPage(),
                'total' => $tecnologias->total(),
            ]
        ], 200);
    }
}