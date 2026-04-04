<?php

namespace App\Http\Controllers\Habilidad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NivelHabilidadController extends Controller
{
    public function index()
    {
        $niveles = \App\Models\NivelDeHabilidad::all();
        return response()->json([
            'message' => 'Niveles de habilidad obtenidos exitosamente',
            'data' => $niveles
        ], 200);
    }
}
