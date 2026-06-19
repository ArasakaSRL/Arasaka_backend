<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Visitante;
use Illuminate\Http\Request;

class VisitantesController extends Controller
{
   public function obtenerDatosVisitantes(Request $request)
    {
        $idPortafolio = $request->query('id_portafolio');

        $query = Visitante::select(
            'id_visitante', 
            'id_portafolio',
            'visitor_id',
            'primera_visita', 
            'ultima_visita'
        );

        // Si viene el id_portafolio en la URL, filtramos
        if ($idPortafolio) {
            $query->where('id_portafolio', $idPortafolio);
        }

        $visitantes = $query->get();

        return response()->json([
            'success' => true,
            'cantidad' => $visitantes->count(),
            'data' => $visitantes
        ]);
    }
}
