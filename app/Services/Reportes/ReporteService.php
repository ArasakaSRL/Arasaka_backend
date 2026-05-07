<?php

namespace App\Services\Reportes;

use App\Models\VisualizacionesPortafolio;
use Carbon\Carbon;

class ReporteService
{
    public function obtener(array $filtros)
    {
        $idPortafolio = $filtros['id_portafolio'];

        if (!empty($filtros['anio'])) {
            $inicio = Carbon::create($filtros['anio'], 1, 1);
            $fin = Carbon::create($filtros['anio'], 12, 31);
        } else {
            $meses = ($filtros['rango'] ?? '6_meses') === '12_meses' ? 12 : 6;

            $inicio = now()->subMonths($meses)->startOfMonth();
            $fin = now()->endOfMonth();
        }

        $data = VisualizacionesPortafolio::query()
            ->where('id_portafolio', $idPortafolio)
            ->whereBetween('fecha', [$inicio, $fin])
->selectRaw("
    EXTRACT(YEAR FROM fecha) as anio,
    EXTRACT(MONTH FROM fecha) as mes_filtrado,
    INITCAP(TO_CHAR(fecha, 'TMMonth')) as mes,
    SUM(vistas) as vistas,
    SUM(clics_linkedin) as clics_linkedin,
    SUM(clics_github) as clics_github,
    SUM(clics_otros) as clics_otros,
    SUM(intentos_contacto) as intentos_contacto,
    SUM(visitas_proyectos) as visitas_proyectos,
    SUM(visitas_habilidades) as visitas_habilidades,
    SUM(visitas_unicas) as visitas_unicas,
    SUM(rebotes) as rebotes
")
->groupByRaw("
    EXTRACT(YEAR FROM fecha),
    EXTRACT(MONTH FROM fecha),
    TO_CHAR(fecha, 'TMMonth')
")
->orderByRaw("
    EXTRACT(YEAR FROM fecha) asc,
    EXTRACT(MONTH FROM fecha) asc
")
            ->get();

        return [
            'rango' => [
                'inicio' => $inicio->toDateString(),
                'fin' => $fin->toDateString(),
            ],
            'data' => $data,
        ];
    }
}