<?php

namespace App\Http\Requests\Portafolio;

use Illuminate\Foundation\Http\FormRequest;

class CrearPortafolioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
  

        'nombre' => [
            'required',
            'string',
            'max:150'
        ],

        'descripcion' => [
            'nullable',
            'string',
            'max:550'
        ],

        'visibilidad' => [
            'boolean'
        ],

        // INFORMACION BASICA (opcionales — se toman del usuario si no vienen)

        'nombre_completo' => [
            'nullable',
            'string',
            'max:150'
        ],

        'gmail' => [
            'nullable',
            'email',
            'max:150'
        ],

        'contrasena' => [
            'nullable',
            'string',
            'min:8'
        ],

        'pais' => [
            'nullable',
            'string',
            'max:100'
        ],

        'foto_perfil' => [
            'nullable',
            'string',
            'max:500'
        ],

        // REDES PROFESIONALES

        'redes_profesionales' => [
            'nullable',
            'array'
        ],

        'redes_profesionales.*.nombre' => [
            'required',
            'string',
            'max:150'
        ],

        'redes_profesionales.*.url' => [
            'required',
            'url'
        ],
    ];
        
    }

    public function messages(): array
    {
        return [
            'nombre.required' =>
                'El nombre del portafolio es obligatorio.',

            'nombre.max' =>
                'El nombre no puede superar los 50 caracteres.',

            'descripcion.max' =>
                'La descripción no puede superar los 550 caracteres.',

            'visibilidad.boolean' =>
                'La visibilidad debe ser verdadero o falso.',
            'redes_profesionales.array' =>
                'Las redes profesionales deben ser un array.',
            'redes_profesionales.*.nombre.required' =>
                'El nombre de la red profesional es obligatorio.',
            'redes_profesionales.*.url.required' =>
                'La URL de la red profesional es obligatoria.',
            'redes_profesionales.*.url.url' =>
                'La URL de la red profesional debe ser una URL válida.',

            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'gmail.required' => 'El gmail es obligatorio.',
            'gmail.email' => 'El gmail debe ser un correo válido.',
            'contrasena.required' => 'La contraseña es obligatoria.',
            'contrasena.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'pais.required' => 'El país es obligatorio.',
        ];
    }
}