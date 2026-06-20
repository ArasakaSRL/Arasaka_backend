<?php

namespace App\Http\Controllers;

use App\Models\RedesProfesionales;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RedesProfesionalesController extends Controller
{
    public function index(string $id_portafolio)
    {
        $redes = RedesProfesionales::where(
            'id_portafolio',
            $id_portafolio
        )->get();

        return response()->json($redes);
    }

  
public function store(Request $request, string $id_portafolio)
{
    $request->validate([
        'redes' => 'required|array|min:1',
        'redes.*.nombre' => 'required|string|max:100',
        'redes.*.url' => 'required|string|max:500',
    ]);

    $redesCreadas = [];

    foreach ($request->redes as $red) {
        $redesCreadas[] = RedesProfesionales::create([
            'id_red_profesional' => (string) \Illuminate\Support\Str::uuid(),
            'id_portafolio' => $id_portafolio,
            'nombre' => $red['nombre'],
            'url' => $red['url'],
        ]);
    }

    return response()->json($redesCreadas, 201);
}
public function update(Request $request, string $id_portafolio)
{
    $request->validate([
        'redes' => 'required|array',
        'redes.*.nombre' => 'required|string|max:100',
        'redes.*.url' => 'required|string|max:500',
    ]);

   
    RedesProfesionales::where(
        'id_portafolio',
        $id_portafolio
    )->delete();

    $redesCreadas = [];

    foreach ($request->redes as $red) {
        $redesCreadas[] = RedesProfesionales::create([
            'id_red_profesional' => (string) \Illuminate\Support\Str::uuid(),
            'id_portafolio' => $id_portafolio,
            'nombre' => $red['nombre'],
            'url' => $red['url'],
        ]);
    }

    return response()->json([
        'message' => 'Redes profesionales actualizadas correctamente',
        'data' => $redesCreadas
    ]);
}
}