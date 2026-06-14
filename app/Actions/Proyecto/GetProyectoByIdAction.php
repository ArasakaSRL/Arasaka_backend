<?php

namespace App\Actions\Proyecto;

use App\Models\Proyecto;

class GetProyectoByIdAction
{
    public function execute($id)
    {
        return Proyecto::where('id_proyecto', $id)
                    ->where('visible', true)
                    ->with(['tecnologias', 'imagenes'])
                    ->first();
    }
}