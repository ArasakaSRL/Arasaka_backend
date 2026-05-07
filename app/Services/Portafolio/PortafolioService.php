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
            ->with($this->relacionesCompletas())
            ->first();
    }

    public function obtenerParaPreview(string $slug, string $idUsuario)
    {
        return Portafolio::query()
            ->where('slug', $slug)
            ->where('id_usuario', $idUsuario)
            ->with($this->relacionesCompletas())
            ->first();
    }

    private function relacionesCompletas(): array
    {
        return [
            'usuario.telefonos',
            'usuario.pais',
            'usuario.profesiones',
            'usuario.idiomas',

            'proyectos.estados',
            'proyectos.imagenes',
            'proyectos.tecnologias',

            'habilidades.tecnologias',

            'experiencias.tipo',

            'servicios',
            'certificaciones.categoria',
            'redesProfesionales',
            'configuracion',
        ];
    }
}