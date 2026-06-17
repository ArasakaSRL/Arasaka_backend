<?php

namespace App\Http\Controllers\Portafolio;

use App\Http\Controllers\Controller;
use App\Models\Profesion;
use App\Models\Tecnologia;
use App\Models\Idioma;
use App\Models\InformacionBasica;

class CatalogoPublicoController extends Controller
{
    // GET /api/public/catalogos
    // Devuelve todas las profesiones, tecnologías, idiomas y países registrados en BD
    public function index()
    {
        $profesiones = Profesion::orderBy('nombre')
            ->get(['id_profesion', 'nombre']);

        $tecnologias = Tecnologia::select('nombre')
            ->distinct()
            ->orderBy('nombre')
            ->pluck('nombre');

        $idiomas = Idioma::orderBy('nombre')
            ->get(['id_idioma', 'nombre']);

        $paises = InformacionBasica::select('pais')
            ->whereNotNull('pais')
            ->where('pais', '!=', '')
            ->distinct()
            ->orderBy('pais')
            ->pluck('pais');

        return response()->json([
            'profesiones' => $profesiones,
            'tecnologias' => $tecnologias,
            'idiomas'     => $idiomas,
            'paises'      => $paises,
        ]);
    }
}
