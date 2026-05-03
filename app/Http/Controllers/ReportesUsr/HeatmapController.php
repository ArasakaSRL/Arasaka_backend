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
}