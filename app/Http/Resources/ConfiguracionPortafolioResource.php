<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConfiguracionPortafolioResource extends JsonResource
{
   public function toArray($request): array
{
    return [
        'id_configuracion_portafolio' => $this->id_configuracion_portafolio,

        'mostrar_proyectos' => $this->mostrar_proyecto,
        'mostrar_habilidades' => $this->mostrar_habilidades,
        'mostrar_experiencias' => $this->mostrar_experiencia,
        'mostrar_servicios' => $this->mostrar_servicios,
        'mostrar_certificaciones' => $this->mostrar_certificaciones,
        'mostrar_redes_profesionales' => $this->mostrar_redes_profesionales,
        'mostrar_cv' => $this->mostrar_cv,
        'mostrar_contacto' => $this->mostrar_contacto,

        'paleta_colores' => $this->paleta_colores,

        'visibilidad' => $this->portafolio?->visibilidad,
        'plantilla' => $this->plantilla,
    ];
}
}