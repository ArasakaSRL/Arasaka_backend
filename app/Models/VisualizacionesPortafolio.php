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
        'numero',
        'fecha',
        'ip_vista',
        'clics_redes',
    ];

    protected $casts = [
        'fecha' => 'date',
        'clics_redes' => 'float',
    ];

    public function portafolio()
    {
        return $this->belongsTo(Portafolio::class, 'id_portafolio', 'id_portafolio');
    }

    public function reportes()
    {
        return $this->hasMany(Reporte::class, 'id_visualizacion_portafolio', 'id_visualizacion_portafolio');
    }
}