<?php

namespace App\Http\Controllers\Proyecto;

use App\Actions\Proyecto\CreateProyectoAction;
use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use App\Http\Requests\Proyecto\StoreProyectoRequest;
use App\Http\Resources\Proyectos\ProyectoResource;
use App\Models\Portafolio;
use App\Services\Proyecto\ProyectoService;
use Mews\Purifier\Facades\Purifier;
use App\Actions\Proyecto\GetProyectosByPortafolio;

class ProyectoController extends Controller
{
    public function __construct(protected ProyectoService $service){}

    private function getIdPortafolio(){
        return request()->user()->portafolio->id_portafolio;
    }

    public function index(GetProyectosByPortafolio $action)
    {
        $proyectos = $action->execute($this->getIdPortafolio());
        //dd(ProyectoResource::collection($proyectos));
        if ($proyectos) {
            $data = [
                'message' => 'Proyectos obtenidos exitosamente',
                'data' => ProyectoResource::collection($proyectos)
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Error al obtener los proyectos'
            ];
            return response()->json($data, 500);
        }
    }

    public function store(StoreProyectoRequest $request, CreateProyectoAction $action)
    {
        $proyecto = $action->execute($request->validated(), $this->getIdPortafolio());

        if ($proyecto) {
            $data = [
                'message' => 'Proyecto creado exitosamente',
                'data' => new ProyectoResource($proyecto)
            ];
            return response()->json($data, 201);
        } else {
            $data = [
                'message' => 'Error al crear el proyecto'
            ];
            return response()->json($data, 500);
        }

    }
}
