<?php

namespace App\Services\Portafolio;

use App\Models\Portafolio;

class PortafolioService
{
    public function obtenerPublicoPorSlug(string $slug)
    {
        return Portafolio::query()
            ->where('slug', $slug)
            ->where('visibilidad', 1)
            ->with([
                'usuario.telefonos',
                'usuario.pais',
                'usuario.profesiones',
                'usuario.idiomas',

                'proyectos.estados',
                'proyectos.imagenes',
                'proyectos.tecnologias',

                'habilidades.categoria',
                'habilidades.nivel',
                'habilidades.tecnologias',

                'experiencias.tipo',

                'servicios',
                'certificaciones.categoria',
                'redesProfesionales',
                'configuracion',
            ])
            ->first();
    }
}