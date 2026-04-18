<?php

namespace App\Services\Configuracion;

use App\Models\ConfiguracionPortafolio;
use App\Models\Portafolio;

class ConfiguracionService
{
    public function getByPortafolio($id_portafolio)
    {
        return ConfiguracionPortafolio::firstOrCreate(
            ['id_portafolio' => $id_portafolio],
            [
                'mostrar_proyecto' => true,
                'mostrar_habilidades' => true,
                'mostrar_experiencia' => true,
                'mostrar_certificaciones' => true,
                'mostrar_servicios' => true,
            ]
        );
    }

public function update($id_portafolio, $data)
{
    $config = $this->getByPortafolio($id_portafolio);

  
    if (array_key_exists('visibilidad', $data)) {
        Portafolio::where('id_portafolio', $id_portafolio)
            ->update([
                'visibilidad' => $data['visibilidad']
            ]);

        unset($data['visibilidad']);
    }

    if (!empty($data)) {
        $mapped = $this->mapToDatabase($data);
        $config->update($mapped);
    }

    return $config->load('portafolio');
}

    private function mapToDatabase($data)
    {
        $map = [
            'mostrar_proyectos' => 'mostrar_proyecto',
            'mostrar_experiencias' => 'mostrar_experiencia',
        ];

        $result = [];

        foreach ($data as $key => $value) {
            $result[$map[$key] ?? $key] = $value;
        }

        return $result;
    }
}