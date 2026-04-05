<?php

namespace App\Http\Controllers\Proyecto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyecto;
use App\Http\Requests\Proyecto\StoreProyectoRequest;
use App\Http\Resources\Proyectos\ProyectoResource;

class ProyectoController extends Controller
{
    public function index(string $idPortafolio)
    {
        // Lógica para obtener todos los proyectos
        $proyectos = Proyecto::where('id_portafolio', $idPortafolio)->with('tecnologias')->get();
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

    public function store(StoreProyectoRequest $request, string $idPortafolio)
    {
        $proyecto = Proyecto::create([
            'id_proyecto' => (string) \Illuminate\Support\Str::uuid(),
            'id_portafolio' => $idPortafolio,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'url_demo' => $request->url_proyecto,
            'url_github' => $request->url_repositorio,
        ]);

        $proyecto->tecnologias()->sync($request->tecnologias);

        if ($proyecto) {
            $data = [
                'message' => 'Proyecto creado exitosamente',
                'data' => ProyectoResource::collection([$proyecto])
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
