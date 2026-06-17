<?php

namespace App\Http\Requests\Certificacion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeleteCertificacionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids' => 'required|array|min:1',
            'ids.*' => 'uuid|exists:certificacion,id_certificacion',
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