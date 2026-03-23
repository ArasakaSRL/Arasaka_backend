<?php

namespace App\Http\Controllers;

use App\Models\Portafolio;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PortafolioController extends Controller
{
    public function index(Request $request)
    {
        $portafolios = Portafolio::where('id_usuario', $request->user()->id_usuario)
            ->with(['proyectos', 'habilidades'])
            ->get();

        return response()->json($portafolios);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'visibilidad' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $portafolio = Portafolio::create([
            'id_portafolio' => (string) Str::uuid(),
            'id_usuario' => $request->user()->id_usuario,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'visibilidad' => $request->visibilidad,
            'fecha_creacion' => now(),
            'fecha_actualizacion' => now(),
        ]);

        return response()->json([
            'message' => 'Portafolio creado',
            'data' => $portafolio
        ], 201);
    }


    public function show($id)
    {
        $portafolio = Portafolio::with([
            'proyectos',
            'habilidades',
            'experiencias',
            'servicios',
            'certificaciones',
            'redesProfesionales',
            'configuracion'
        ])->find($id);

        if (!$portafolio) {
            return response()->json([
                'message' => 'Portafolio no encontrado'
            ], 404);
        }

        return response()->json($portafolio);
    }

    public function update(Request $request, $id)
    {
        $portafolio = Portafolio::find($id);

        if (!$portafolio) {
            return response()->json([
                'message' => 'Portafolio no encontrado'
            ], 404);
        }


        if ($portafolio->id_usuario !== $request->user()->id_usuario) {
            return response()->json([
                'message' => 'No autorizado'
            ], 403);
        }

        $portafolio->update([
            'nombre' => $request->nombre ?? $portafolio->nombre,
            'descripcion' => $request->descripcion ?? $portafolio->descripcion,
            'visibilidad' => $request->visibilidad ?? $portafolio->visibilidad,
            'fecha_actualizacion' => now(),
        ]);

        return response()->json([
            'message' => 'Portafolio actualizado',
            'data' => $portafolio
        ]);
    }


    public function destroy(Request $request, $id)
    {
        $portafolio = Portafolio::find($id);

        if (!$portafolio) {
            return response()->json([
                'message' => 'Portafolio no encontrado'
            ], 404);
        }

        if ($portafolio->id_usuario !== $request->user()->id_usuario) {
            return response()->json([
                'message' => 'No autorizado'
            ], 403);
        }

        $portafolio->delete();

        return response()->json([
            'message' => 'Portafolio eliminado'
        ]);
    }
}