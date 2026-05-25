<?php

namespace App\Http\Controllers\Portafolio;

use App\Http\Controllers\Controller;
use App\Http\Resources\Portafolio\PublicPortafolioResource;
use App\Actions\Portafolio\ObtenerPortafolioPublicoAction;
use App\Models\Portafolio;

class PublicPortafolioController extends Controller
{
    public function __construct(
        private ObtenerPortafolioPublicoAction $action
    ) {}

    public function show(string $slug)
    {
        $portafolio = $this->action->execute($slug);

        if (!$portafolio || !$portafolio->usuario || $portafolio->usuario->estado === false) {
            return response()->json([
                'mensaje' => 'Este portafolio ya no está disponible',
                'codigo' => 'no_disponible',
            ], 404);
        }

        if (!$portafolio->link_activo) {
            return response()->json([
                'mensaje' => 'Este portafolio ya no está disponible',
                'codigo' => 'link_inactivo',
            ], 404);
        }

        if ($portafolio->fecha_expiracion_link && $portafolio->fecha_expiracion_link->isPast()) {
            return response()->json([
                'mensaje' => 'Este portafolio ya no está disponible',
                'codigo' => 'link_expirado',
            ], 404);
        }

        return new PublicPortafolioResource($portafolio);
    }

    //devolver todos los portafolios publicos activos
    public function index(){
        $portafolios = Portafolio::where('link_activo', true)
            ->whereHas('usuario', function ($query) {
                $query->where('estado', true);
            })
            ->with([
                'usuario',
                'informacionBasica',
                'telefonos',
                'profesiones',
                'idiomas',
                'proyectos.estados',
                'proyectos.imagenes',
                'proyectos.tecnologias.categorias',
                'habilidades.tecnologias.categorias',
                'experiencias.tipo',
                'servicios',
                'certificaciones.categoria',
                'redesProfesionales',
                'configuracion',
            ])
            ->get();

        return PublicPortafolioResource::collection($portafolios);
    }
}
