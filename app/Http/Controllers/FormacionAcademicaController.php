<?php

namespace App\Http\Controllers;

use App\Models\FormacionAcademica;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFormacionAcademicaRequest;

class FormacionAcademicaController extends Controller
{
    /**
     * LISTAR
     */
    public function index()
    {
        $formaciones = FormacionAcademica::all();

        return response()->json([
            'message' => 'Lista de formaciones academicas',
            'data' => $formaciones
        ]);
    }

    /**
     * OBTENER UNO
     */
    /**
 * OBTENER FORMACIONES DE UN PORTAFOLIO
 */
public function obtenerPorPortafolio(string $id_portafolio)
{
    $formaciones = FormacionAcademica::where(
        'id_portafolio',
        $id_portafolio
    )->get();

    return response()->json([
        'message' => 'Formaciones académicas del portafolio',
        'data' => $formaciones
    ]);
}
    public function show(string $id)
    {
        $formacion = FormacionAcademica::find($id);

        if (!$formacion) {
            return response()->json([
                'message' => 'Formacion academica no encontrada'
            ], 404);
        }

        return response()->json([
            'data' => $formacion
        ]);
    }

    /**
     * CREAR
     */
    public function store(StoreFormacionAcademicaRequest $request)
    {
        $formacion = FormacionAcademica::create(
            $request->validated()
        );

        return response()->json([
            'message' => 'Formacion academica creada correctamente',
            'data' => $formacion
        ], 201);
    }

    /**
     * ACTUALIZAR
     */
    public function update(
        StoreFormacionAcademicaRequest $request,
        string $id
    ) {

        $formacion = FormacionAcademica::find($id);

        if (!$formacion) {
            return response()->json([
                'message' => 'Formacion academica no encontrada'
            ], 404);
        }

        $formacion->update(
            $request->validated()
        );

        return response()->json([
            'message' => 'Formacion academica actualizada correctamente',
            'data' => $formacion
        ]);
    }

    /**
     * ELIMINAR
     */
    public function destroy(string $id)
    {
        $formacion = FormacionAcademica::find($id);

        if (!$formacion) {
            return response()->json([
                'message' => 'Formacion academica no encontrada'
            ], 404);
        }

        $formacion->delete();

        return response()->json([
            'message' => 'Formacion academica eliminada correctamente'
        ]);
    }
}