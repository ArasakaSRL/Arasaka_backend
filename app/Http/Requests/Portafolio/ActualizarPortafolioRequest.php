<?php

namespace App\Http\Requests\Portafolio;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarPortafolioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'nombre' => [
                'sometimes',
                'string',
                'max:50',
            ],

            'descripcion' => [
                'nullable',
                'string',
                'max:550',
            ],

            'visibilidad' => [
                'nullable',
                'boolean',
            ],
        ];
    }
}