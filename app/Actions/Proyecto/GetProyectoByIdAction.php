<?php

namespace App\Actions\Proyecto;

use App\Models\Proyecto;

class GetProyectoByIdAction
{
    public function execute($id)
    {
        return Proyecto::where('id', $id)
                    ->where('visible', true)
                    ->with(['tecnologias', 'imagenes'])
                    ->first();
    }
}