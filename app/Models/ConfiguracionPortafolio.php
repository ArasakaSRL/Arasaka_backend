<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionPortafolio extends Model
{
    use HasFactory;

    protected $table = 'configuracion_portafolio';
    protected $primaryKey = 'id_configuracion_portafolio';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_portafolio',
        'mostrar_proyecto',
        'mostrar_habilidades',
        'mostrar_experiencia',
        'mostrar_certificaciones',
        'mostrar_servicios',
        'mostrar_redes_profesionales',
        'mostrar_cv',
        'mostrar_contacto',
        'paleta_colores',
        'plantilla',
    ];

    protected $casts = [
        'mostrar_proyecto' => 'boolean',
        'mostrar_habilidades' => 'boolean',
        'mostrar_experiencia' => 'boolean',
        'mostrar_certificaciones' => 'boolean',
        'mostrar_servicios' => 'boolean',
        'mostrar_redes_profesionales' => 'boolean',
        'mostrar_cv' => 'boolean',
        'mostrar_contacto' => 'boolean',
    ];

    public function portafolio()
    {
        return $this->belongsTo(Portafolio::class, 'id_portafolio', 'id_portafolio');
    }
}