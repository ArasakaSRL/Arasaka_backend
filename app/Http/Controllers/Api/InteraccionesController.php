<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Visitante;
use App\Models\InteraccionCertificacion;
use App\Models\InteraccionExperiencia;
use App\Models\InteraccionHabilidadBlanda;
use App\Models\InteraccionHabilidadTecnica;
use App\Models\InteraccionPerfil;
use App\Models\InteraccionProyecto;
use Illuminate\Http\Request;

class InteraccionesController extends Controller
{
    public function obtenerTodas(Request $request)
    {
        $idPortafolio = $request->query('id_portafolio');

        if (!$idPortafolio) {
            return response()->json([
                'success' => false,
                'message' => 'El parámetro id_portafolio es requerido para filtrar las interacciones.'
            ], 400);
        }

        // 1. Obtenemos solo los id_visitante asociados a ese id_portafolio
        $idVisitantes = Visitante::where('id_portafolio', $idPortafolio)
            ->pluck('id_visitante');

        // 2. Consultamos cada tabla filtrando por el array de visitantes obtenido
        return response()->json([
            'success' => true,
            'id_portafolio' => $idPortafolio,
            'data' => [
                'interaccion_certificacion' => InteraccionCertificacion::whereIn('id_visitante', $idVisitantes)->get(),
                'interaccion_experiencia' => InteraccionExperiencia::whereIn('id_visitante', $idVisitantes)->get(),
                'interaccion_habilidad_blanda' => InteraccionHabilidadBlanda::whereIn('id_visitante', $idVisitantes)->get(),
                'interaccion_habilidad_tecnica' => InteraccionHabilidadTecnica::whereIn('id_visitante', $idVisitantes)->get(),
                'interaccion_perfil' => InteraccionPerfil::whereIn('id_visitante', $idVisitantes)->get(),
                'interaccion_proyectos' => InteraccionProyecto::whereIn('id_visitante', $idVisitantes)->get(),
            ]
        ]);
    }
}
