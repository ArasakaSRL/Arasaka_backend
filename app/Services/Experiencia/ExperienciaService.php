<?php

namespace App\Services\Experiencia;

use App\Models\Experiencia;
use Illuminate\Support\Str;

class ExperienciaService
{
    public function list()
    {
        return Experiencia::with(['tipo', 'portafolio'])->get();
    }

    public function find(string $id)
    {
        return Experiencia::with(['tipo', 'portafolio'])->findOrFail($id);
    }

    public function create(array $data)
    {
        $data['id_experiencia'] = Str::uuid()->toString();
        return Experiencia::create($data);
    }

    public function update(string $id, array $data)
    {
        $experiencia = $this->find($id);
        $experiencia->update($data);
        return $experiencia;
    }

    public function delete(string $id)
    {
        $experiencia = $this->find($id);
        $experiencia->delete();
        return $experiencia;
    }
    public function getByPortafolio(string $portafolioId, string $order = 'asc')
   {
    return Experiencia::with(['tipo', 'portafolio'])
        ->where('id_portafolio', $portafolioId)
        ->orderBy('fecha_inicio', $order) 
        ->get();
   }
}