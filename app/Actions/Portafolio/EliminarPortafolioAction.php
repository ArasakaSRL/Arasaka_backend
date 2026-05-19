<?php

namespace App\Actions\Portafolio;

use App\Models\Portafolio;
use Illuminate\Support\Facades\DB;

class EliminarPortafolioAction
{
    public function ejecutar(
        Portafolio $portafolio
    ): void {

        DB::transaction(function () use ($portafolio) {

            $portafolio->configuracion()?->delete();

            $portafolio->visualizaciones()->delete();

            $portafolio->delete();
        });
    }
}