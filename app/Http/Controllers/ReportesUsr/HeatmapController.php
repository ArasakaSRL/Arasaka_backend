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
        $permitidos = ['clic_expandir', 'clic_cerrar','clic_general'];

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

    private function resolverPortafolio(Request $request): Portafolio
    {
        $usuario = $request->user();
        $idPortafolio = $request->query('id_portafolio');

        if ($idPortafolio) {
            return Portafolio::where('id_portafolio', $idPortafolio)
                ->where('id_usuario', $usuario->id_usuario)
                ->firstOrFail();
        }

        return Portafolio::where('id_usuario', $usuario->id_usuario)->firstOrFail();
    }

    public function getVisitantes(Request $request): JsonResponse
    {
        $portafolio = $this->resolverPortafolio($request);

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
        $portafolio = $this->resolverPortafolio($request);

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
        $portafolio = $this->resolverPortafolio($request);

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


    public function getVisitasPorMes(Request $request): JsonResponse
    {
        $portafolio = $this->resolverPortafolio($request);

        $datos = DB::select("
            SELECT
                TO_CHAR(primera_visita, 'Mon') AS mes,
                TO_CHAR(primera_visita, 'MM')  AS mes_num,
                TO_CHAR(primera_visita, 'YYYY') AS anio,
                COUNT(*)                        AS visitas
            FROM visitante
            WHERE id_portafolio = ?
            AND primera_visita >= NOW() - INTERVAL '6 months'
            GROUP BY mes, mes_num, anio
            ORDER BY anio, mes_num
        ", [$portafolio->id_portafolio]);

        return response()->json($datos);
    }

    public function getCrecimientoMensual(Request $request): JsonResponse
    {
        $portafolio = $this->resolverPortafolio($request);

        // visitantes únicos acumulados por mes
        $datos = DB::select("
            SELECT
                TO_CHAR(primera_visita, 'Mon') AS mes,
                TO_CHAR(primera_visita, 'MM')  AS mes_num,
                TO_CHAR(primera_visita, 'YYYY') AS anio,
                COUNT(*)                        AS total
            FROM visitante
            WHERE id_portafolio = ?
            AND primera_visita >= NOW() - INTERVAL '7 months'
            GROUP BY mes, mes_num, anio
            ORDER BY anio, mes_num
        ", [$portafolio->id_portafolio]);

        return response()->json($datos);
    }

    // Método genérico reutilizable
    private function insertClicCoords(
        string $tabla,
        string $campoId,
        array  $data,
        ?string $idEntidad = null
    ): void {
        $idEntidadSql = $idEntidad ? ', ' . $campoId : '';
        $idEntidadVal = $idEntidad ? ', ?' : '';

        $params = $idEntidad
            ? [$data['campo'], $idEntidad, $data['x'], $data['y'], $data['visitor_id'], $data['portfolio_slug']]
            : [$data['campo'], $data['x'], $data['y'], $data['visitor_id'], $data['portfolio_slug']];

        DB::statement("
            INSERT INTO {$tabla} (id_visitante, campo{$idEntidadSql}, x, y)
            SELECT v.id_visitante, ?{$idEntidadVal}, ?, ?
            FROM visitante v
            JOIN portafolio p ON p.id_portafolio = v.id_portafolio
            WHERE v.visitor_id = ?
            AND p.slug       = ?
        ", $params);
    }


    // Habilidades Técnicas
    public function trackClicCoordsTecnicas(Request $request): JsonResponse
    {
        $data = $request->validate([
            'visitor_id'     => 'required|uuid',
            'portfolio_slug' => 'required|string',
            'id_habilidad'   => 'nullable|uuid',
            'campo'          => 'required|string',
            'x'              => 'required|numeric|between:0,1',
            'y'              => 'required|numeric|between:0,1',
        ]);

        $this->insertClicCoords('clic_habilidad_tecnica', 'id_habilidad', $data, $data['id_habilidad'] ?? null);
        return response()->json(['ok' => true]);
    }

    // Habilidades Blandas
    public function trackClicCoordsBlandas(Request $request): JsonResponse
    {
        $data = $request->validate([
            'visitor_id'     => 'required|uuid',
            'portfolio_slug' => 'required|string',
            'id_habilidad'   => 'nullable|uuid',
            'campo'          => 'required|string',
            'x'              => 'required|numeric|between:0,1',
            'y'              => 'required|numeric|between:0,1',
        ]);

        $this->insertClicCoords('clic_habilidad_blanda', 'id_habilidad', $data, $data['id_habilidad'] ?? null);
        return response()->json(['ok' => true]);
    }

    // Experiencia
    public function trackClicCoordsExperiencia(Request $request): JsonResponse
    {
        $data = $request->validate([
            'visitor_id'     => 'required|uuid',
            'portfolio_slug' => 'required|string',
            'id_experiencia' => 'nullable|uuid',
            'campo'          => 'required|string',
            'x'              => 'required|numeric|between:0,1',
            'y'              => 'required|numeric|between:0,1',
        ]);

        $this->insertClicCoords('clic_experiencia', 'id_experiencia', $data, $data['id_experiencia'] ?? null);
        return response()->json(['ok' => true]);
    }

    // Proyecto
    public function trackClicCoordsProyecto(Request $request): JsonResponse
    {
        $data = $request->validate([
            'visitor_id'     => 'required|uuid',
            'portfolio_slug' => 'required|string',
            'id_proyecto'    => 'nullable|uuid',
            'campo'          => 'required|string',
            'x'              => 'required|numeric|between:0,1',
            'y'              => 'required|numeric|between:0,1',
        ]);

        $this->insertClicCoords('clic_proyecto', 'id_proyecto', $data, $data['id_proyecto'] ?? null);
        return response()->json(['ok' => true]);
    }

    // Certificacion
    public function trackClicCoordsCertificacion(Request $request): JsonResponse
    {
        $data = $request->validate([
            'visitor_id'       => 'required|uuid',
            'portfolio_slug'   => 'required|string',
            'id_certificacion' => 'nullable|uuid',
            'campo'            => 'required|string',
            'x'                => 'required|numeric|between:0,1',
            'y'                => 'required|numeric|between:0,1',
        ]);

        $this->insertClicCoords('clic_certificacion', 'id_certificacion', $data, $data['id_certificacion'] ?? null);
        return response()->json(['ok' => true]);
    }

    // Método genérico reutilizable
    private function getClicsFromTable(string $tabla, string $idPortafolio): array
    {
        return DB::select("
            SELECT
                c.campo,
                c.x,
                c.y,
                COUNT(*) AS intensidad
            FROM {$tabla} c
            JOIN visitante v ON v.id_visitante = c.id_visitante
            WHERE v.id_portafolio = ?
            AND c.x IS NOT NULL
            AND c.y IS NOT NULL
            GROUP BY c.campo, c.x, c.y
            ORDER BY intensidad DESC
        ", [$idPortafolio]);
    }


    public function getClicsTecnicas(Request $request): JsonResponse
    {
        $portafolio = $this->resolverPortafolio($request);
        return response()->json($this->getClicsFromTable('clic_habilidad_tecnica', $portafolio->id_portafolio));
    }

    public function getClicsBlandas(Request $request): JsonResponse
    {
        $portafolio = $this->resolverPortafolio($request);
        return response()->json($this->getClicsFromTable('clic_habilidad_blanda', $portafolio->id_portafolio));
    }

    public function getClicsExperiencia(Request $request): JsonResponse
    {
        $portafolio = $this->resolverPortafolio($request);
        return response()->json($this->getClicsFromTable('clic_experiencia', $portafolio->id_portafolio));
    }

    public function getClicsProyecto(Request $request): JsonResponse
    {
        $portafolio = $this->resolverPortafolio($request);
        return response()->json($this->getClicsFromTable('clic_proyecto', $portafolio->id_portafolio));
    }

    public function getClicsCertificacion(Request $request): JsonResponse
    {
        $portafolio = $this->resolverPortafolio($request);
        return response()->json($this->getClicsFromTable('clic_certificacion', $portafolio->id_portafolio));
    }

    public function trackClicCoords(Request $request): JsonResponse
    {
        $data = $request->validate([
            'visitor_id'     => 'required|uuid',
            'portfolio_slug' => 'required|string',
            'campo'          => 'required|string',
            'x'              => 'required|numeric|between:0,1',
            'y'              => 'required|numeric|between:0,1',
        ]);

        DB::statement("
            INSERT INTO clic_perfil (id_visitante, campo, x, y)
            SELECT v.id_visitante, ?, ?, ?
            FROM visitante v
            JOIN portafolio p ON p.id_portafolio = v.id_portafolio
            WHERE v.visitor_id = ?
            AND p.slug       = ?
        ", [
            $data['campo'],
            $data['x'],
            $data['y'],
            $data['visitor_id'],
            $data['portfolio_slug'],
        ]);

        return response()->json(['ok' => true]);
    }

    public function getClicsPerfil(Request $request): JsonResponse
    {
        $portafolio = $this->resolverPortafolio($request);

        $clics = DB::select("
            SELECT cp.campo, cp.x, cp.y, COUNT(*) as intensidad
            FROM clic_perfil cp
            JOIN visitante v ON v.id_visitante = cp.id_visitante
            WHERE v.id_portafolio = ?
            GROUP BY cp.campo, cp.x, cp.y
            ORDER BY intensidad DESC
        ", [$portafolio->id_portafolio]);

        return response()->json($clics);
    }
}

