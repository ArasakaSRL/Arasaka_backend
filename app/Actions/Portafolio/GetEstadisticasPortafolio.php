<?php

namespace App\Actions\Portafolio;

use App\Models\Portafolio;
use App\Services\Portafolio\PortafolioEstadisticaService;

class GetEstadisticasPortafolio
{
    public function __construct(
        protected PortafolioEstadisticaService $service
    ) {}

    public function execute($idPortafolio = null, $user = null)
    {
      
        if ($idPortafolio) {

            $query = Portafolio::where('id_portafolio', $idPortafolio);

          
            if ($user) {
                $query->where(function ($q) use ($user) {
                    $q->where('visibilidad', true)
                      ->orWhere('id_usuario', $user->id_usuario);
                });
            } else {
               
                $query->where('visibilidad', true);
            }

            $portafolio = $query->firstOrFail();

            return $this->service->getEstadisticas($portafolio->id_portafolio);
        }

      
        if ($user) {
            $portafolio = Portafolio::where('id_usuario', $user->id_usuario)
                ->latest('fecha_creacion')
                ->first();

            if (!$portafolio) {
                throw new \Exception('El usuario no tiene portafolio');
            }

            return $this->service->getEstadisticas($portafolio->id_portafolio);
        }

        throw new \Exception('No se pudo determinar el portafolio');
    }
}