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
            'nombre' => 'required|string|max:255|unique:proyecto,nombre',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'tecnologias' => 'required|array||min:1',
            'tecnologias.*' => 'exists:tecnologias,id_tecnologia',
            'url_imagen'=> 'sometimes|array',
            'url_imagen.*'=> 'url',
            'url_demo' => 'nullable|url',
            'url_github' => 'nullable|url',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del proyecto es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede superar los 255 caracteres.',
            'nombre.unique' => 'Ya existe un proyecto con ese nombre.',

            'descripcion.string' => 'La descripción debe ser texto.',

            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',

            'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',

            'tecnologias.required' => 'Debe seleccionar al menos una tecnología.',
            'tecnologias.array' => 'Las tecnologías deben ser un arreglo.',
            'tecnologias.min' => 'Debe seleccionar al menos una tecnología.',
            'tecnologias.*.exists' => 'Una o más tecnologías seleccionadas no existen.',

            'url_imagen.array' => 'Las URL de las imágenes deben ser un arreglo.',
            'url_imagen.*.url' => 'Cada URL de imagen debe ser una URL válida.',

            'url_demo.url' => 'La URL de la demo debe ser una URL válida.',
            'url_github.url' => 'La URL de GitHub debe ser una URL válida.',
        ];
    }
}
