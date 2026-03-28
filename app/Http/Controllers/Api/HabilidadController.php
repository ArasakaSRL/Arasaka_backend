<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Habilidad\StoreHabilidadRequest;
use App\Models\Habilidad;
use App\Models\NivelDeHabilidad;
use App\Models\Tecnologia;

class HabilidadController extends Controller
{
    public function index()
    {
        // Lógica para obtener todas las habilidades
    }

    public function store(StoreHabilidadRequest $request){

        $habilidad = Habilidad::create([
            'id_habilidad' => (string) \Illuminate\Support\Str::uuid(),
            'id_portafolio' => $request->id_portafolio,
            'id_categoria_habilidad' => $request->id_categoria_habilidad,
            'id_nivel_habilidad' => $request->nivel,
            'nombre' => Tecnologia::find($request->id_tecnologia)->nombre ?? $request->nombre, // Si es técnica, se asigna el nombre de la tecnología; si es blanda, se usa el nombre proporcionado 
        ]);

        if ($habilidad) {
            $data = [
                'message' => 'Habilidad creada exitosamente',
                'data' => $habilidad
            ];
            return response()->json($data, 201);
        } else {
            $data = [
                'message' => 'Error al crear la habilidad',
            ];
            return response()->json($data, 500);
        }   
    }
}
