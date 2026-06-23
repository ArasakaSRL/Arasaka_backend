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
use Illuminate\Support\Facades\DB;

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

        $idVisitantes = Visitante::where('id_portafolio', $idPortafolio)
            ->pluck('id_visitante');

        // ── Proyectos: JOIN proyecto → nombre ────────────────────────────────
        $proyectos = DB::table('interaccion_proyecto as ip')
            ->join('proyecto as p', 'ip.id_proyecto', '=', 'p.id_proyecto')
            ->whereIn('ip.id_visitante', $idVisitantes)
            ->select(
                'ip.*',
                'p.nombre as nombre_proyecto'
            )
            ->get();

        // ── Certificaciones: JOIN certificacion → nombre ──────────────────────
        $certificaciones = DB::table('interaccion_certificacion as ic')
            ->join('certificacion as c', 'ic.id_certificacion', '=', 'c.id_certificacion')
            ->whereIn('ic.id_visitante', $idVisitantes)
            ->select(
                'ic.*',
                'c.titulo as nombre_certificacion'
            )
            ->get();

        // ── Habilidades técnicas: JOIN habilidad → nombre ─────────────────────
        $habilidadesTecnicas = DB::table('interaccion_habilidad_tecnica as iht')
            ->join('habilidad as h', 'iht.id_habilidad', '=', 'h.id_habilidad')
            ->whereIn('iht.id_visitante', $idVisitantes)
            ->select(
                'iht.*',
                'h.nombre as nombre_habilidad'
            )
            ->get();

        // ── Habilidades blandas: JOIN habilidad → nombre ──────────────────────
        $habilidadesBlandas = DB::table('interaccion_habilidad_blanda as ihb')
            ->join('habilidad as h', 'ihb.id_habilidad', '=', 'h.id_habilidad')
            ->whereIn('ihb.id_visitante', $idVisitantes)
            ->select(
                'ihb.*',
                'h.nombre as nombre_habilidad'
            )
            ->get();

        // ── Experiencia: JOIN experiencia → cargo ─────────────────────────────
        $experiencias = DB::table('interaccion_experiencia as ie')
            ->join('experiencia as e', 'ie.id_experiencia', '=', 'e.id_experiencia')
            ->whereIn('ie.id_visitante', $idVisitantes)
            ->select(
                'ie.*',
                'e.cargo as nombre_experiencia'
            )
            ->get();

        // ── Perfil: sin cambios ───────────────────────────────────────────────
        $perfil = InteraccionPerfil::whereIn('id_visitante', $idVisitantes)->get();

        return response()->json([
            'success' => true,
            'id_portafolio' => $idPortafolio,
            'data' => [
                'interaccion_certificacion'    => $certificaciones,
                'interaccion_experiencia'      => $experiencias,
                'interaccion_habilidad_blanda' => $habilidadesBlandas,
                'interaccion_habilidad_tecnica'=> $habilidadesTecnicas,
                'interaccion_perfil'           => $perfil,
                'interaccion_proyectos'        => $proyectos,
            ]
        ]);
    }
}