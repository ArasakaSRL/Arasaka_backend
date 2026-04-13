<?php

namespace App\Http\Requests\Proyecto;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProyectoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|nullable|string',
            'fecha_inicio' => 'sometimes|date',
            'fecha_fin' => 'sometimes|nullable|date|after_or_equal:fecha_inicio',
            'tecnologias' => 'sometimes|array',
            'tecnologias.*' => 'exists:tecnologias,id_tecnologia',
            'url_demo' => 'sometimes|nullable|url',
            'url_github' => 'sometimes|nullable|url',
        ];
    }
}
