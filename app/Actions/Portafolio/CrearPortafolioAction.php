<?php

namespace App\Actions\Portafolio;

use App\Models\Portafolio;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\ConfiguracionPortafolio;
use App\Models\VisualizacionesPortafolio;
use App\Models\RedesProfesionales;
class CrearPortafolioAction
{
    public function ejecutar(
        array $datos,
        string $idUsuario
    ): Portafolio {

        return DB::transaction(function () use (
            $datos,
            $idUsuario
        ) {

            $portafolio = Portafolio::create([

                'id_portafolio' => Str::uuid(),

                'id_usuario' => $idUsuario,

                'nombre' => $datos['nombre'],

                'descripcion' =>
                    $datos['descripcion'] ?? null,

                'visibilidad' =>
                    $datos['visibilidad'] ?? true,

                'fecha_creacion' => now(),

                'fecha_actualizacion' => now(),

                'link_activo' => false,
            ]);

            ConfiguracionPortafolio::create([

                'id_portafolio' =>
                    $portafolio->id_portafolio,

                'mostrar_proyecto' => true,
                'mostrar_habilidades' => true,
                'mostrar_experiencia' => true,
                'mostrar_certificaciones' => true,
                'mostrar_servicios' => true,

                'paleta_colores' => json_encode([
                    'primary' => '#000000',
                    'secondary' => '#ffffff',
                ]),
            ]);

            VisualizacionesPortafolio::create([

                'id_portafolio' =>
                    $portafolio->id_portafolio,

                'fecha' => now()->toDateString(),
            ]);
            if (!empty($datos['redes_profesionales'])) {

    foreach ($datos['redes_profesionales'] as $red) {

        RedesProfesionales::create([

            'id_portafolio' =>
                $portafolio->id_portafolio,

            'nombre' =>
                $red['nombre'],

            'url' =>
                $red['url'],
        ]);
    }
}

            return $portafolio->load([
                'configuracion',
                'visualizaciones',
                'redesProfesionales',
            ]);
        });
    }
}