<?php

namespace App\Actions\Certificacion;

use App\Models\CategoriaCertificacion;

class CreateCategoriaAction
{
    public function execute(array $data)
    {
        return CategoriaCertificacion::create($data);
    }
}