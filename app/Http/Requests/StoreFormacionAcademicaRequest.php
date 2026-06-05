<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormacionAcademicaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'id_portafolio' => [
                'required',
                'uuid',
                'exists:portafolio,id_portafolio'
            ],

            'institucion' => [
                'required',
                'string',
                'min:5',
                'max:100'
            ],

            'titulo' => [
                'required',
                'string',
                'min:5',
                'max:50'
            ],

            'nivel' => [
                'required',
                'in:Tecnico,Licenciatura,Maestria,Doctorado,Diplomado,Curso'
            ],

            'fecha_inicio' => [
                'required',
                'date'
            ],

            'fecha_fin' => [
                'nullable',
                'date'
            ],

            'descripcion' => [
                'nullable',
                'string',
                'max:550'
            ]
        ];
    }
}