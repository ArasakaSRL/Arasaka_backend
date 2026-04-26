<?php

namespace App\Actions\Proyecto;

use App\Models\Proyecto;

class GetProyectosByPortafolio
{

    public function execute($idPortafolio)
    {
        return Proyecto::where('id_portafolio', $idPortafolio)
                ->with(['tecnologias', 'imagenes'])
                ->orderBy('fecha_creacion', 'desc')
                ->get();
    }
}
