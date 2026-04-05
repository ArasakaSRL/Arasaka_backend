<?php

namespace App\Http\Requests\Certificacion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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

    public function messages()
    {
        return [
            'titulo.required' => 'El título es obligatorio',
            'titulo.max' => 'El título no puede superar los 255 caracteres',

            'descripcion.max' => 'La descripción no puede superar los 500 caracteres',

            'institucion_emisora.required' => 'La institución emisora es obligatoria',
            'institucion_emisora.max' => 'Máximo 150 caracteres',

            'fecha_obtencion.required' => 'La fecha de obtención es obligatoria',
            'fecha_obtencion.date' => 'Debe ser una fecha válida',

            'url_archivo.url' => 'Debe ser una URL válida',

            'orientacion_imagen.in' => 'La orientación debe ser horizontal o vertical',

            'id_categoria_certificacion.exists' => 'La categoría seleccionada no existe',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Error en los datos enviados',
            'errors' => $validator->errors()
        ], 422));
    }
}