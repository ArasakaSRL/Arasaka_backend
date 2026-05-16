<?php

namespace App\Services\Portafolio;

use App\Models\Portafolio;
use App\Actions\Portafolio\CrearPortafolioAction;
use App\Actions\Portafolio\EliminarPortafolioAction;
use App\Actions\Portafolio\ActualizarPortafolioAction;
class PortafolioService
{
    
    public function __construct(
        protected CrearPortafolioAction $crearAction,
        protected ActualizarPortafolioAction $actualizarAction,
        protected EliminarPortafolioAction $eliminarAction,
    ) {}

    public function crear(
        array $datos,
        string $idUsuario
    ): Portafolio {

        return $this->crearAction
            ->ejecutar($datos, $idUsuario);
    }

    public function actualizar(
        Portafolio $portafolio,
        array $datos
    ): Portafolio {

        return $this->actualizarAction
            ->ejecutar($portafolio, $datos);
    }

    public function eliminar(
        Portafolio $portafolio
    ): void {

        $this->eliminarAction
            ->ejecutar($portafolio);
    }
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