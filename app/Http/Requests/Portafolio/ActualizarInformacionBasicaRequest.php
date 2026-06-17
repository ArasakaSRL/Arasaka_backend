<?php

namespace App\Http\Requests\Portafolio;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ActualizarInformacionBasicaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'nombre_completo' => ['sometimes', 'string', 'max:150'],
            'gmail'           => ['sometimes', 'email', 'max:150'],
            'pais'            => ['sometimes', 'nullable', 'string', 'max:100'],
            'foto_perfil'            => ['sometimes', 'nullable', 'string', 'max:500'],
            'foto_perfil_public_id'  => ['sometimes', 'nullable', 'string', 'max:255'],
            'biografia'              => ['sometimes', 'nullable', 'string', 'max:550'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_completo.max' => 'El nombre completo no puede superar los 150 caracteres.',
            'gmail.email'         => 'El gmail debe ser un correo válido.',
            'gmail.max'           => 'El gmail no puede superar los 150 caracteres.',
            'pais.max'            => 'El país no puede superar los 100 caracteres.',
        ];
    }
}
