<?php

namespace App\Services\Tecnologia;

use App\Models\Tecnologia;

class TecnologiaService
{
    public function listar($cantidad = 9)
    {
        return Tecnologia::orderBy('nombre', 'asc')
            ->paginate($cantidad);
    }

    public function crear(array $data)
    {
        Tecnologia::create($data);

        return Tecnologia::orderBy('nombre', 'asc')
            ->paginate(9);
    }

    public function mostrar(string $id)
    {
        return Tecnologia::findOrFail($id);
    }

    public function actualizar(string $id, array $data)
    {
        $tecnologia = Tecnologia::findOrFail($id);

        $tecnologia->update($data);

        return Tecnologia::orderBy('nombre', 'asc')
            ->paginate(9);
    }

    public function eliminar(string $id)
    {
        $tecnologia = Tecnologia::findOrFail($id);

        $tecnologia->delete();

        return Tecnologia::orderBy('nombre', 'asc')
            ->paginate(9);
    }
}