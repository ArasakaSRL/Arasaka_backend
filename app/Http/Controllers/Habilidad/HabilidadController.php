<?php

namespace App\Http\Controllers\Habilidad;

use App\Http\Controllers\Controller;
use App\Http\Requests\Habilidad\StoreHabilidadRequest;
use App\Models\Habilidad;
use App\Models\Tecnologia;
use App\Http\Resources\Habilidad\HabilidadResource;
use App\Models\Portafolio;
use App\Actions\Habilidad\CreateHabilidadAction;
use App\Actions\Habilidad\GetHabilidadByPortafolio;

class HabilidadController extends Controller
{
    protected function getPortafolioId()
    {
        return request()->user()->id_usuario->portafolio->id_portafolio;
    }

    public function index(GetHabilidadByPortafolio $action)
    {
        $habilidades = $action->execute($this->getPortafolioId());
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
        }
    }

    public function store(StoreHabilidadRequest $request, CreateHabilidadAction $action){

        $habilidad = $action->execute($request->validated(), $this->getPortafolioId());
        
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
