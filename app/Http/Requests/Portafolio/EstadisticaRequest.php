<?php

namespace App\Http\Requests\Portafolio;

use Illuminate\Foundation\Http\FormRequest;

class EstadisticaRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id_portafolio' => 'nullable|uuid|exists:portafolio,id_portafolio'
        ];
    }
}