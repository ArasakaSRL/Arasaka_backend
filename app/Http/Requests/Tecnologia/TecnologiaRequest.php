<?php

namespace App\Http\Requests\Tecnologia;

use Illuminate\Foundation\Http\FormRequest;

class TecnologiaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:225',
            'descripcion' => 'nullable|string|max:255',
            'logo' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la tecnología es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede superar los 225 caracteres.',

            'descripcion.string' => 'La descripción debe ser texto.',
            'descripcion.max' => 'La descripción no puede superar los 255 caracteres.',

            'logo.string' => 'El logo debe ser una cadena válida.',
        ];
    }
}