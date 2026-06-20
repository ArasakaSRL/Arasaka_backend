<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
                'max:50',
                Rule::unique('formacion_academica', 'titulo')
                    ->where(function ($query) {
                        return $query->where('nivel', request('nivel'));
                    })
                    ->ignore($this->route('id'), 'id_formacion_academica')
            ],

            'nivel' => [
                'required',
                'in:Tecnico,Licenciatura,Maestria,Doctorado,PostDoctorado,Especialidad'
            ],

            'fecha_inicio' => [
                'nullable',
                'date'
            ],

            'fecha_fin' => [
                'required',
                'date'
            ],

            'descripcion' => [
                'nullable',
                'string',
                'max:550'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.unique' => 'Ya existe una formación académica con el mismo título y nivel.'
        ];
    }
}