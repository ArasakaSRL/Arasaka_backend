<?php

namespace App\Http\Controllers\Certificacion;
use App\Http\Controllers\Controller;
use App\Services\Certificacion\CategoriaCertificacionService;
use App\Http\Requests\Certificacion\StoreCategoriaRequest;
use App\Http\Requests\Certificacion\UpdateCategoriaRequest;
use App\Http\Resources\CategoriaCertificacionResource;
use App\Models\CategoriaCertificacion;

class CategoriaCertificacionController extends Controller
{
    protected $service;

    public function __construct(CategoriaCertificacionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return CategoriaCertificacionResource::collection(
            $this->service->getAll()
        );
    }

    public function store(StoreCategoriaRequest $request)
    {
        $categoria = $this->service->create($request->validated());

        return new CategoriaCertificacionResource($categoria);
    }

    public function show($id)
    {
        $categoria = $this->service->getById($id);

        return new CategoriaCertificacionResource($categoria);
    }

    public function update(UpdateCategoriaRequest $request, CategoriaCertificacion $categoria)
    {
        $categoria = $this->service->update($categoria, $request->validated());

        return new CategoriaCertificacionResource($categoria);
    }

    public function destroy(CategoriaCertificacion $categoria)
    {
        $this->service->delete($categoria);

        return response()->json([
            'message' => 'Categoria eliminada correctamente'
        ]);
    }
}