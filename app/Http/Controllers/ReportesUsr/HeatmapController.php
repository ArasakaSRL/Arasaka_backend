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

    public function getVisitantes(Request $request): JsonResponse
    {
        $usuario = $request->user();  // ← faltaba el punto y coma

        $portafolio = Portafolio::where('id_usuario', $usuario->id_usuario)
            ->firstOrFail();

        $datos = DB::select("
            SELECT
                COUNT(*)                                          AS total_visitantes,
                COUNT(CASE WHEN primera_visita = ultima_visita
                    THEN 1 END)                                AS visitantes_nuevos,
                COUNT(CASE WHEN primera_visita != ultima_visita
                    THEN 1 END)                                AS visitantes_recurrentes,
                MAX(ultima_visita)                               AS ultima_visita
            FROM visitante
            WHERE id_portafolio = ?
        ", [$portafolio->id_portafolio]);

        return response()->json($datos[0]);
    }

    public function getInteraccionesPerfil(Request $request): JsonResponse
    {
        $usuario = $request->user();

        \Log::info('Usuario autenticado:', [
            'id_usuario' => $usuario->id_usuario,
            'nombre'     => $usuario->nombre,
        ]);

        $portafolio = Portafolio::where('id_usuario', $usuario->id_usuario)
            ->firstOrFail();

        \Log::info('Portfolio encontrado:', [
            'id_portafolio' => $portafolio->id_portafolio,
        ]);

        $datos = DB::select("
            SELECT
                SUM(ip.hover_foto_count)    AS hover_foto_count,
                SUM(ip.hover_foto_ms)       AS hover_foto_ms,
                SUM(ip.hover_correo_count)  AS hover_correo_count,
                SUM(ip.hover_correo_ms)     AS hover_correo_ms,
                SUM(ip.clic_foto_perfil)    AS clic_foto_perfil,
                SUM(ip.clic_correo)         AS clic_correo,
                SUM(ip.clic_linkedin)       AS clic_linkedin,
                SUM(ip.clic_github)         AS clic_github,
                SUM(ip.clic_contactar)      AS clic_contactar,
                SUM(ip.clic_descargar_cv)   AS clic_descargar_cv
            FROM interaccion_perfil ip
            JOIN visitante v ON v.id_visitante = ip.id_visitante
            WHERE v.id_portafolio = ?
        ", [$portafolio->id_portafolio]);

        return response()->json($datos[0] ?? []);
    }

    public function getInteraccionesHabilidadesTecnicas(Request $request): JsonResponse
    {
        $usuario    = $request->user();
        $portafolio = Portafolio::where('id_usuario', $usuario->id_usuario)->firstOrFail();

        $datos = DB::select("
            SELECT
                SUM(iht.clic_expandir) AS clic_expandir,
                SUM(iht.clic_cerrar)   AS clic_cerrar
            FROM interaccion_habilidad_tecnica iht
            JOIN visitante v ON v.id_visitante = iht.id_visitante
            WHERE v.id_portafolio = ?
        ", [$portafolio->id_portafolio]);

        return response()->json($datos[0] ?? []);
    }
}

