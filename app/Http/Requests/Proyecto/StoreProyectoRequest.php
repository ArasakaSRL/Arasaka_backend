<?php

namespace App\Http\Requests\Proyecto;

use Illuminate\Foundation\Http\FormRequest;

class StoreProyectoRequest extends FormRequest
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
            //'id_portafolio' => "required|string|exists:portafolio,id_portafolio",
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'tecnologias' => 'required|array||min:1',
            'tecnologias.*' => 'exists:tecnologias,id_tecnologia',
            'url_imagen'=> 'sometimes|array|min:1',
            'url_imagen.*'=> 'url',
            'url_demo' => 'nullable|url',
            'url_github' => 'nullable|url',
        ];
    }
}
