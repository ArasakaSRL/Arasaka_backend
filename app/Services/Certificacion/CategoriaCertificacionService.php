<?php

namespace App\Services\Certificacion;

use App\Models\CategoriaCertificacion;
use App\Actions\Certificacion\CreateCategoriaAction;
use App\Actions\Certificacion\UpdateCategoriaAction;
use App\Actions\Certificacion\DeleteCategoriaAction;

class CategoriaCertificacionService
{
    public function getAll()
    {
        return CategoriaCertificacion::all();
    }

    public function getById($id)
    {
        return CategoriaCertificacion::findOrFail($id);
    }

    public function create(array $data)
    {
        return (new CreateCategoriaAction())->execute($data);
    }

    public function update(CategoriaCertificacion $categoria, array $data)
    {
        return (new UpdateCategoriaAction())->execute($categoria, $data);
    }

    public function delete(CategoriaCertificacion $categoria)
    {
        return (new DeleteCategoriaAction())->execute($categoria);
    }
}