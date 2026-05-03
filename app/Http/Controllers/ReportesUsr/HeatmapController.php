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
}