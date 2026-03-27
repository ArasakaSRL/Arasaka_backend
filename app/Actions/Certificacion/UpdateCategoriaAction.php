<?php
namespace App\Actions\Certificacion;

use App\Models\CategoriaCertificacion;

class UpdateCategoriaAction
{
    public function execute(CategoriaCertificacion $categoria, array $data)
    {
        $categoria->update($data);
        return $categoria;
    }
}