<?php

namespace App\Http\Requests\Habilidad;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\CategoriaHabilidad;
use App\Enums\NivelHabilidad;
use Illuminate\Validation\Rules\Enum;

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
            'id_portafolio' => "required|string|exists:portafolio,id_portafolio",
            'categoria_habilidad' => ['sometimes', new Enum(CategoriaHabilidad::class)],
            'nivel' => ['sometimes', new Enum(NivelHabilidad::class)],
            'id_tecnologia' => 'sometimes|exists:tecnologias,id_tecnologia',
            'nombre' => 'sometimes|string',
        ];
        
        return $rules;
    }
}
