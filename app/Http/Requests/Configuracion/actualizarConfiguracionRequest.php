<?php

namespace App\Http\Requests\Configuracion;

use Illuminate\Foundation\Http\FormRequest;

class actualizarConfiguracionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mostrar_proyectos' => 'sometimes|boolean',
            'mostrar_habilidades' => 'sometimes|boolean',
            'mostrar_experiencias' => 'sometimes|boolean',
            'mostrar_servicios' => 'sometimes|boolean',
            'mostrar_certificaciones' => 'sometimes|boolean',
            'mostrar_redes_profesionales' => 'sometimes|boolean',
            'mostrar_cv' => 'sometimes|boolean',
            'mostrar_contacto' => 'sometimes|boolean',
            'paleta_colores' => 'nullable|string',
            'visibilidad' => 'sometimes|boolean',
        ];
    }
}