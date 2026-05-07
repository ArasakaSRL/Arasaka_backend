<?php

namespace App\Services\Portafolio;

use App\Models\Portafolio;

class PortafolioEstadisticaService
{
    public function getEstadisticas($idPortafolio)
    {
        $portafolio = Portafolio::with([
            'habilidades',
            'experiencias',
            'visualizaciones',
            'proyectos' 
        ])->findOrFail($idPortafolio);

        $totalExperiencias = $portafolio->experiencias->count();

       
        $totalProyectos = $portafolio->proyectos->count();

      
        $habilidades = $portafolio->habilidades
            ->groupBy('categoria_habilidad')
            ->map(function ($grupo) {
                return $grupo->groupBy('nivel')
                    ->map(fn($items) => $items->count());
            });

      
        $totalVisitas = $portafolio->visualizaciones->sum('vistas');
        $visitasUnicas = $portafolio->visualizaciones->sum('visitas_unicas');

        return [
            'experiencias' => $totalExperiencias,
            'proyectos' => $totalProyectos, 
            'habilidades' => $habilidades,
            'visitas' => [
                'totales' => $totalVisitas,
                'unicas' => $visitasUnicas,
            ],
        ];
    }
}