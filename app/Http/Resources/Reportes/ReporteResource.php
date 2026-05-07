<?php

namespace App\Http\Resources\Reportes;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReporteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'rango' => $this['rango'],

            'meses' => collect($this['data'])->map(function ($item) {
                return [
                    'anio' => (int) $item->anio,
                    'mes' => (string) $item->mes,

                    'vistas' => (int) $item->vistas,
                    'clics_linkedin' => (int) $item->clics_linkedin,
                    'clics_github' => (int) $item->clics_github,
                    'clics_otros' => (int) $item->clics_otros,
                    'intentos_contacto' => (int) $item->intentos_contacto,
                    'visitas_proyectos' => (int) $item->visitas_proyectos,
                    'visitas_habilidades' => (int) $item->visitas_habilidades,
                    'visitas_unicas' => (int) $item->visitas_unicas,
                    'rebotes' => (int) $item->rebotes,
                ];
            }),
        ];
    }
}