<?php

namespace App\Http\Requests\Reportes;

use Illuminate\Foundation\Http\FormRequest;

class ReporteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id_portafolio' => ['nullable', 'uuid'],
            'anio' => ['nullable', 'integer'],
            'rango' => ['nullable', 'in:6_meses,12_meses'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}