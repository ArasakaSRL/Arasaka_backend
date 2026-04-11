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
use App\Http\Requests\Proyecto\UpdateProyectoRequest;

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

    public function show($id)
    {
        $proyecto = Proyecto::find($id);

        if (!$proyecto) {
            return response()->json(['message' => 'Proyecto no encontrado'], 404);
        }

        if ($proyecto->id_portafolio !== $this->getIdPortafolio()) {
            return response()->json(['message' => 'No autorizado para ver este proyecto'], 403);
        }

        return response()->json(['data' => new ProyectoResource($proyecto)], 200);
    }

    public function update(UpdateProyectoRequest $request, String $proyecto)
    {
        $proyecto = $this->service->actualizar($request->validated(), $proyecto);
        if ($proyecto) {
            $data = [
                'message' => 'Proyecto actualizado exitosamente',
                'data' => new ProyectoResource($proyecto)
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Error al actualizar el proyecto'
            ];
            return response()->json($data, 500);
        }
        
    }

        public function destroy($id)
        {
            $proyecto = Proyecto::find($id);
    
            if (!$proyecto) {
                return response()->json(['message' => 'Proyecto no encontrado'], 404);
            }
    
            if ($proyecto->id_portafolio !== $this->getIdPortafolio()) {
                return response()->json(['message' => 'No autorizado para eliminar este proyecto'], 403);
            }
    
            $proyecto->delete();
    
            return response()->json(['message' => 'Proyecto eliminado exitosamente'], 200);
        }
}
