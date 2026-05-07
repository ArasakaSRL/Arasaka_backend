<?php
namespace App\Actions\Certificacion;

use App\Models\Certificacion;

class GetCertificacionesByCategoria
{
    public function execute($idPortafolio, $idCategoria)
    {
        return Certificacion::with('categoria')
            ->where('id_portafolio', $idPortafolio)
            ->where('id_categoria_certificacion', $idCategoria)
            ->get();
    }
}