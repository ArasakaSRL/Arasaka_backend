<?php

namespace App\Http\Controllers\Tecnologia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tecnologia;

class TecnologiaController extends Controller
{
    public function index()
    {
        // Lógica para obtener todas las tecnologías
        $tecnologias = Tecnologia::all();

        if(is_null($tecnologias)){
            $data = [
                'message' => 'No se encontraron tecnologías',
                'data' => []
            ];
            return response()->json($data, 404);
        } else {
            $data = [
                'message' => 'Tecnologías obtenidas exitosamente',
                'data' => $tecnologias
            ];
            return response()->json($data, 200);
        }
    }

    public function store(Request $request)
    {
        // Lógica para crear una nueva tecnología
    }

    public function show($id)
    {
        // Lógica para mostrar una tecnología específica
    }

    public function update(Request $request, $id)
    {
        // Lógica para actualizar una tecnología existente
    }

    public function destroy($id)
    {
        // Lógica para eliminar una tecnología
    }
}
