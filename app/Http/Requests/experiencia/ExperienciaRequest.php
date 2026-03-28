<?php

namespace App\Http\Requests\experiencia;

use Illuminate\Foundation\Http\FormRequest;

class ExperienciaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_portafolio' => 'required|uuid|exists:portafolio,id_portafolio',
            'id_tipo_experiencia' => 'nullable|uuid|exists:tipo_experiencia,id_tipo_experiencia',
            'cargo' => 'required|string|max:100',
            'nombre_organizacion' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string|max:550',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'vigente' => 'boolean',
        ];
    }
}