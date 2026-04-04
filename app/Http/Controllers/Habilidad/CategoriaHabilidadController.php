<?php

namespace App\Http\Controllers\Habilidad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriaHabilidadController extends Controller
{
    public function index()
    {
        $categorias = \App\Models\CategoriaHabilidad::all();
        return response()->json([
            'message' => 'Categorías de habilidades obtenidas exitosamente',
            'data' => $categorias
        ], 200);
    }
}
