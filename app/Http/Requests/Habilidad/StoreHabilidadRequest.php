<?php

namespace App\Http\Requests\Habilidad;

use App\Enums\CategoriaHabilidad;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\NivelHabilidad;

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
            'categoria_habilidad' => ['required', new Enum(CategoriaHabilidad::class)],
            'nivel' => ['required', new Enum(NivelHabilidad::class)],
        ];

        if ($this->categoria_habilidad == CategoriaHabilidad::TECNICA->value) {
            $rules['id_tecnologia'] = 'required|exists:tecnologias,id_tecnologia';
        }

        if ($this->categoria_habilidad == CategoriaHabilidad::BLANDA->value) {
            $rules['nombre'] = 'required|string';
        }
        return $rules;
    }
}
