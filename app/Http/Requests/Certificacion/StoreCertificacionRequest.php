<?php

namespace App\Http\Requests\Certificacion;
use Illuminate\Foundation\Http\FormRequest;


class StoreCertificacionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'institucion_emisora' => 'required|string|max:150',
            'fecha_obtencion' => 'required|date',
            'url_archivo' => 'nullable|url',
            'orientacion_imagen' => 'nullable|in:horizontal,vertical',
            'id_categoria_certificacion' => 'nullable|exists:categoria_certificacion,id_categoria_certificacion',
        ];
    }
}
