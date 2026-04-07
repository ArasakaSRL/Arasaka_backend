<?php

namespace App\Services\Experiencia;

use App\Models\Experiencia;
use Illuminate\Support\Str;

class ExperienciaService
{
    public function listByPortafolio(string $portafolioId)
    {
        return Experiencia::with(['tipo'])
            ->where('id_portafolio', $portafolioId)
            ->orderBy('fecha_inicio', 'asc')
            ->get();
    }

    public function find(string $id)
    {
        return Experiencia::with(['tipo', 'portafolio'])
            ->findOrFail($id);
    }

    public function create(array $data, string $portafolioId)
    {
        $data['id_experiencia'] = Str::uuid()->toString();
        $data['id_portafolio'] = $portafolioId;

        return Experiencia::create($data);
    }

    public function updateModel(Experiencia $exp, array $data)
    {
        $exp->update($data);
        return $exp;
    }

    public function deleteModel(Experiencia $exp)
    {
        $exp->delete();
    }
}