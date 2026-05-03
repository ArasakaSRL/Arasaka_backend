<?php

namespace App\Http\Controllers\reportesUsr;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Portafolio;

class HeatmapController extends Controller
{
    public function iniciar(Request $request): JsonResponse
    {
        $data = $request->validate([
            'visitor_id'     => 'required|uuid',
            'portfolio_slug' => 'required|string',
        ]);

        $portafolio = Portafolio::where('slug', $data['portfolio_slug'])
            ->firstOrFail();

        DB::statement("
            INSERT INTO visitante (id_portafolio, visitor_id)
            VALUES (?, ?)
            ON CONFLICT (visitor_id, id_portafolio)
            DO UPDATE SET ultima_visita = NOW()
        ", [
            $portafolio->id_portafolio,
            $data['visitor_id']
        ]);

        return response()->json(['ok' => true]);
    }

    public function track(Request $request): JsonResponse
    {
        $permitidos = [
            'hover_foto_count', 'hover_foto_ms',
            'hover_correo_count', 'hover_correo_ms',
            'clic_foto_perfil', 'clic_correo',
            'clic_linkedin',    'clic_github',
            'clic_contactar',   'clic_descargar_cv',
        ];

        $data = $request->validate([
            'visitor_id'     => 'required|uuid',
            'portfolio_slug' => 'required|string',
            'campo'          => 'required|string',
            'valor'          => 'required|integer|min:1',
        ]);

        if (!in_array($data['campo'], $permitidos)) {
            return response()->json(['ok' => true]);
        }

        $campo = $data['campo'];

        DB::statement("
            INSERT INTO interaccion_perfil (id_visitante)
            SELECT id_visitante FROM visitante
            WHERE visitor_id = ?
            AND id_portafolio = (
                SELECT id_portafolio FROM portafolio WHERE slug = ?
            )
            ON CONFLICT (id_visitante)
            DO UPDATE SET
                {$campo}             = interaccion_perfil.{$campo} + ?,
                ultima_interaccion   = NOW()
        ", [
            $data['visitor_id'],
            $data['portfolio_slug'],
            $data['valor']
        ]);

        return response()->json(['ok' => true]);
    }

    public function trackHabilidadBlanda(Request $request): JsonResponse
    {
        $data = $request->validate([
            'visitor_id'     => 'required|uuid',
            'portfolio_slug' => 'required|string',
            'id_habilidad'   => 'required|uuid',
            'campo'          => 'required|string',
            'valor'          => 'required|integer|min:1',
        ]);

        $campo = $data['campo'];

        // ── Boolean — manejo especial ──
        if ($campo === 'fue_visible') {
            DB::statement("
                INSERT INTO interaccion_habilidad_blanda
                    (id_visitante, id_habilidad, fue_visible)
                SELECT v.id_visitante, ?, true
                FROM visitante v
                JOIN portafolio p ON p.id_portafolio = v.id_portafolio
                WHERE v.visitor_id = ?
                AND p.slug       = ?
                ON CONFLICT (id_visitante, id_habilidad)
                DO UPDATE SET
                    fue_visible        = true,
                    ultima_interaccion = NOW()
            ", [
                $data['id_habilidad'],
                $data['visitor_id'],
                $data['portfolio_slug'],
            ]);

            return response()->json(['ok' => true]);
        }

        // ── Numéricos ──
        $permitidos = ['hover_count', 'hover_ms'];

        if (!in_array($campo, $permitidos)) {
            return response()->json(['ok' => true]);
        }

        DB::statement("
            INSERT INTO interaccion_habilidad_blanda
                (id_visitante, id_habilidad, {$campo})
            SELECT v.id_visitante, ?, ?
            FROM visitante v
            JOIN portafolio p ON p.id_portafolio = v.id_portafolio
            WHERE v.visitor_id = ?
            AND p.slug       = ?
            ON CONFLICT (id_visitante, id_habilidad)
            DO UPDATE SET
                {$campo}           = interaccion_habilidad_blanda.{$campo} + ?,
                ultima_interaccion = NOW()
        ", [
            $data['id_habilidad'],
            $data['valor'],
            $data['visitor_id'],
            $data['portfolio_slug'],
            $data['valor'],
        ]);

        return response()->json(['ok' => true]);
    }

    public function trackHabilidadTecnica(Request $request): JsonResponse
    {
        $data = $request->validate([
            'visitor_id'     => 'required|uuid',
            'portfolio_slug' => 'required|string',
            'id_habilidad'   => 'required|uuid',
            'campo'          => 'required|string',
            'valor'          => 'required|integer|min:1',
        ]);

        $campo     = $data['campo'];
        $permitidos = ['clic_expandir', 'clic_cerrar'];

        if (!in_array($campo, $permitidos)) {
            return response()->json(['ok' => true]);
        }

        DB::statement("
            INSERT INTO interaccion_habilidad_tecnica
                (id_visitante, id_habilidad, {$campo})
            SELECT v.id_visitante, ?, ?
            FROM visitante v
            JOIN portafolio p ON p.id_portafolio = v.id_portafolio
            WHERE v.visitor_id = ?
            AND p.slug       = ?
            ON CONFLICT (id_visitante, id_habilidad)
            DO UPDATE SET
                {$campo}           = interaccion_habilidad_tecnica.{$campo} + ?,
                ultima_interaccion = NOW()
        ", [
            $data['id_habilidad'],
            $data['valor'],
            $data['visitor_id'],
            $data['portfolio_slug'],
            $data['valor'],
        ]);

        return response()->json(['ok' => true]);
    }

    
        public function trackExperiencia(Request $request): JsonResponse
    {
        $data = $request->validate([
            'visitor_id'     => 'required|uuid',
            'portfolio_slug' => 'required|string',
            'id_experiencia' => 'required|uuid',
            'campo'          => 'required|string',
            'valor'          => 'required|integer|min:1',
        ]);

        $campo = $data['campo'];

        // ── Boolean ──
        if ($campo === 'fue_visible') {
            DB::statement("
                INSERT INTO interaccion_experiencia
                    (id_visitante, id_experiencia, fue_visible)
                SELECT v.id_visitante, ?, true
                FROM visitante v
                JOIN portafolio p ON p.id_portafolio = v.id_portafolio
                WHERE v.visitor_id = ?
                AND p.slug       = ?
                ON CONFLICT (id_visitante, id_experiencia)
                DO UPDATE SET
                    fue_visible        = true,
                    ultima_interaccion = NOW()
            ", [
                $data['id_experiencia'],
                $data['visitor_id'],
                $data['portfolio_slug'],
            ]);

            return response()->json(['ok' => true]);
        }

        // ── Numéricos ──
        $permitidos = ['hover_count', 'hover_ms'];

        if (!in_array($campo, $permitidos)) {
            return response()->json(['ok' => true]);
        }

        DB::statement("
            INSERT INTO interaccion_experiencia
                (id_visitante, id_experiencia, {$campo})
            SELECT v.id_visitante, ?, ?
            FROM visitante v
            JOIN portafolio p ON p.id_portafolio = v.id_portafolio
            WHERE v.visitor_id = ?
            AND p.slug       = ?
            ON CONFLICT (id_visitante, id_experiencia)
            DO UPDATE SET
                {$campo}           = interaccion_experiencia.{$campo} + ?,
                ultima_interaccion = NOW()
        ", [
            $data['id_experiencia'],
            $data['valor'],
            $data['visitor_id'],
            $data['portfolio_slug'],
            $data['valor'],
        ]);

        return response()->json(['ok' => true]);
    }

    public function trackProyecto(Request $request): JsonResponse
    {
        $data = $request->validate([
            'visitor_id'     => 'required|uuid',
            'portfolio_slug' => 'required|string',
            'id_proyecto'    => 'required|uuid',
            'campo'          => 'required|string',
            'valor'          => 'required|integer|min:1',
        ]);

        $campo     = $data['campo'];
        $permitidos = ['hover_count', 'hover_ms', 'clic_github', 'clic_demo', 'clic_detalle'];

        if (!in_array($campo, $permitidos)) {
            return response()->json(['ok' => true]);
        }

        DB::statement("
            INSERT INTO interaccion_proyecto
                (id_visitante, id_proyecto, {$campo})
            SELECT v.id_visitante, ?, ?
            FROM visitante v
            JOIN portafolio p ON p.id_portafolio = v.id_portafolio
            WHERE v.visitor_id = ?
            AND p.slug       = ?
            ON CONFLICT (id_visitante, id_proyecto)
            DO UPDATE SET
                {$campo}           = interaccion_proyecto.{$campo} + ?,
                ultima_interaccion = NOW()
        ", [
            $data['id_proyecto'],
            $data['valor'],
            $data['visitor_id'],
            $data['portfolio_slug'],
            $data['valor'],
        ]);

        return response()->json(['ok' => true]);
    }

    public function trackCertificacion(Request $request): JsonResponse
    {
        $data = $request->validate([
            'visitor_id'       => 'required|uuid',
            'portfolio_slug'   => 'required|string',
            'id_certificacion' => 'required|uuid',
            'campo'            => 'required|string',
            'valor'            => 'required|integer|min:1',
        ]);

        $campo      = $data['campo'];
        $permitidos = [
            'hover_count', 'hover_ms',
            'clic_abrir_modal', 'clic_ver_credencial', 'clic_cerrar_modal'
        ];

        if (!in_array($campo, $permitidos)) {
            return response()->json(['ok' => true]);
        }

        DB::statement("
            INSERT INTO interaccion_certificacion
                (id_visitante, id_certificacion, {$campo})
            SELECT v.id_visitante, ?, ?
            FROM visitante v
            JOIN portafolio p ON p.id_portafolio = v.id_portafolio
            WHERE v.visitor_id = ?
            AND p.slug       = ?
            ON CONFLICT (id_visitante, id_certificacion)
            DO UPDATE SET
                {$campo}           = interaccion_certificacion.{$campo} + ?,
                ultima_interaccion = NOW()
        ", [
            $data['id_certificacion'],
            $data['valor'],
            $data['visitor_id'],
            $data['portfolio_slug'],
            $data['valor'],
        ]);

        return response()->json(['ok' => true]);
    }
}