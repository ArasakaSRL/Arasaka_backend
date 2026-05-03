<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisualizacionesPortafolio extends Model
{
    use HasFactory;

    protected $table = 'visualizaciones_portafolio';
    protected $primaryKey = 'id_visualizacion_portafolio';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_portafolio',
        'fecha',
        'vistas',
        'clics_linkedin',
        'clics_github',
        'clics_otros',
        'intentos_contacto',
        'visitas_proyectos',
        'visitas_habilidades',
        'visitas_unicas',
        'rebotes',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function portafolio()
    {
        return $this->belongsTo(
            Portafolio::class,
            'id_portafolio',
            'id_portafolio'
        );
    }
}