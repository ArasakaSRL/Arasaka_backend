<?php

namespace App\Http\Controllers\Proyecto;

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
        return auth()->user()->portafolio->id_portafolio;
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

    public function store(StoreProyectoRequest $request)
    {
        $idUsuario = $request->user()->id_usuario;
        $idPortafolio = Portafolio::where('id_usuario', $idUsuario)->first()->id_portafolio;

        $proyecto = Proyecto::create([
            'id_proyecto' => (string) \Illuminate\Support\Str::uuid(),
            'id_portafolio' => $idPortafolio,
            'nombre' => $request->nombre,
            'descripcion' => Purifier::clean($request->descripcion), // filtra el campo descripcion para evitar XSS
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'url_demo' => $request->url_proyecto,
            'url_github' => $request->url_repositorio,
            'fecha_creacion' => now(),
            'fecha_actualizacion' => now(),
        ]);

        $proyecto->tecnologias()->sync($request->tecnologias);

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
