<?php

namespace App\Http\Requests\Habilidad;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHabilidadRequest extends FormRequest
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
        $rules = [
            'id_categoria_habilidad' => 'sometimes|exists:categoria_habilidad,id_categoria_habilidad',
            'nivel' => 'sometimes|exists:nivel_de_habilidad,id_nivel_habilidad',
        ];

        if ($this->id_categoria_habilidad == CategoriaHabilidad::TECNICA) {
            $rules['id_tecnologia'] = 'sometimes|exists:tecnologias,id_tecnologia';
        }

        if ($this->id_categoria_habilidad == CategoriaHabilidad::BLANDA) {
            $rules['nombre'] = 'sometimes|string';
        }
        return $rules;
    }
}
