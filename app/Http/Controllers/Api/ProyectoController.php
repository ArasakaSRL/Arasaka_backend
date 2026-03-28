<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProyectoRequest;
use Illuminate\Http\Request;
use App\Actions\proyectos\CrearProyectoAction;
use App\Models\Proyecto;
use Illuminate\Support\Facades\Validator;

class ProyectoController extends Controller
{
    public function index()
    {
        // Lógica para obtener todos los proyectos
    }

    public function store(Request $request)
    {
        // Lógica para crear un nuevo proyecto
        $Validator = Validator::make($request->all(), [
            'id_portafolio' => 'required|exists:portafolio,id_portafolio',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'id_tecnologia' => 'nullable|exists:tecnologias,id',
            'url_proyecto' => 'nullable|url',
            'url_repositorio' => 'nullable|url',
        ]);

        if ($Validator->fails()) {
            $data = [
                'message' => 'Error de validación',
                'errors' => $Validator->errors()
            ];
            return response()->json($data, 422);
        }

        $proyecto = Proyecto::create([
            'id_proyecto' => (string) \Illuminate\Support\Str::uuid(),
            'id_portafolio' => $request->id_portafolio,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'id_tecnologia' => $request->id_tecnologia,
            'url_proyecto' => $request->url_proyecto,
            'url_repositorio' => $request->url_repositorio,
        ]);

        if ($proyecto) {
            $data = [
                'message' => 'Proyecto creado exitosamente',
                'data' => $proyecto
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
