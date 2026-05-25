<?php

namespace App\Http\Controllers\Portafolio;

use App\Http\Controllers\Controller;
use App\Http\Resources\Portafolio\PublicPortafolioResource;
use App\Actions\Portafolio\ObtenerPortafolioPublicoAction;
use App\Models\Portafolio;
use Illuminate\Http\Request;

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

    // GET /api/public/portafolios
    // Acepta: busqueda, profesion, pais, tecnologia, idioma, orden, por_pagina
    public function index(Request $request)
    {
        $query = Portafolio::where('link_activo', true)
            ->whereHas('usuario', function ($q) {
                $q->where('estado', true);
            });

        // Búsqueda de texto libre
        if ($request->filled('busqueda')) {
            $term = '%' . $request->busqueda . '%';
            $query->where(function ($q) use ($term) {
                $q->where('nombre', 'like', $term)
                  ->orWhere('descripcion', 'like', $term)
                  ->orWhereHas('informacionBasica', fn ($q2) => $q2
                      ->where('nombre_completo', 'like', $term)
                      ->orWhere('biografia', 'like', $term)
                  )
                  ->orWhereHas('profesiones', fn ($q2) => $q2->where('nombre', 'like', $term))
                  ->orWhereHas('servicios', fn ($q2) => $q2->where('nombre', 'like', $term));
            });
        }

        // Filtro por profesión (nombre exacto)
        if ($request->filled('profesion')) {
            $query->whereHas('profesiones', fn ($q) => $q->where('nombre', $request->profesion));
        }

        // Filtro por país (desde informacion_basica)
        if ($request->filled('pais')) {
            $query->whereHas('informacionBasica', fn ($q) => $q->where('pais', $request->pais));
        }

        // Filtro por tecnología (busca en proyectos y habilidades)
        if ($request->filled('tecnologia')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('proyectos.tecnologias', fn ($q2) => $q2->where('nombre', $request->tecnologia))
                  ->orWhereHas('habilidades.tecnologias', fn ($q2) => $q2->where('nombre', $request->tecnologia));
            });
        }

        // Filtro por idioma (nombre exacto)
        if ($request->filled('idioma')) {
            $query->whereHas('idiomas', fn ($q) => $q->where('nombre', $request->idioma));
        }

        // Ordenamiento
        switch ($request->get('orden', 'nombre_asc')) {
            case 'nombre_desc':
                $query->orderBy('nombre', 'desc');
                break;
            case 'proyectos':
                $query->withCount('proyectos')->orderBy('proyectos_count', 'desc');
                break;
            case 'habilidades':
                $query->withCount('habilidades')->orderBy('habilidades_count', 'desc');
                break;
            default:
                $query->orderBy('nombre', 'asc');
        }

        $porPagina = min((int) $request->get('por_pagina', 9), 50);

        $portafolios = $query->with([
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
            ->paginate($porPagina);

        return PublicPortafolioResource::collection($portafolios);
    }
}
