<?php

namespace App\Http\Requests\Habilidad;

use App\Models\CategoriaHabilidad;
use Illuminate\Foundation\Http\FormRequest;

class StoreHabilidadRequest extends FormRequest
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
            'id_categoria_habilidad' => 'required|exists:categoria_habilidad,id_categoria_habilidad',
            'id_nivel_habilidad' => 'required|exists:nivel_de_habilidad,id_nivel_habilidad',
        ];

        if ($this->id_categoria_habilidad == CategoriaHabilidad::TECNICA) {
            $rules['id_tecnologia'] = 'required|exists:tecnologias,id_tecnologia';
        }

        if ($this->id_categoria_habilidad == CategoriaHabilidad::BLANDA) {
            $rules['nombre'] = 'required|string';
        }
        return $rules;
    }
}
