<?php

namespace App\Actions\Certificacion;

use App\Models\CategoriaCertificacion;

class DeleteCategoriaAction
{
    public function execute(CategoriaCertificacion $categoria)
    {
        $categoria->delete();
        return true;
    }
}