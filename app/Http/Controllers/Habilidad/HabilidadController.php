<?php

namespace App\Http\Controllers\Habilidad;

use App\Http\Controllers\Controller;
use App\Http\Requests\Habilidad\StoreHabilidadRequest;
use App\Models\Habilidad;
use App\Models\Tecnologia;
use App\Http\Resources\Habilidad\HabilidadResource;
use App\Models\Portafolio;

class HabilidadController extends Controller
{
    public function index()
    {
        $idUsuario = request()->user()->id_usuario;
        dd($idUsuario);
        /* $idPortafolio = Portafolio::where("id_usuario", $idUsuario)->value("id_portafolio");

        $habilidades = Habilidad::where("id_portafolio", $idPortafolio)->with('categoria', 'nivel')->get();
        //dd($habilidades);
        if ($habilidades) {
            $data = [
                "message" => "Habilidades obtenidas exitosamente",
                "data" => HabilidadResource::collection($habilidades),
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                "message" => "Error al obtener las habilidades",
            ];
            return response()->json($data, 500);
        } */
    }

    public function store(StoreHabilidadRequest $request){

        $idUsuario = request()->user()->id_usuario;
        $idPortafolio = Portafolio::where("id_usuario", $idUsuario)->value("id_portafolio");

        $habilidad = Habilidad::create([
            'id_habilidad' => (string) \Illuminate\Support\Str::uuid(),
            'id_portafolio' => $idPortafolio,
            'id_categoria_habilidad' => $request->id_categoria_habilidad,
            'id_nivel_habilidad' => $request->nivel,
            'nombre' => Tecnologia::find($request->id_tecnologia)->nombre ?? $request->nombre, // Si es técnica, se asigna el nombre de la tecnología; si es blanda, se usa el nombre proporcionado 
        ]);
        
        if ($habilidad) {
            $data = [
                'message' => 'Habilidad creada exitosamente',
                'data' => HabilidadResource::collection([$habilidad])
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
