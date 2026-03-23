<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;

    protected $table = 'reporte';
    protected $primaryKey = 'id_reporte';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_visualizacion_portafolio',
        'tipo',
        'fecha_creacion',
        'direccion_ip',
    ];

    protected $casts = [
        'fecha_creacion' => 'date',
    ];

    public function visualizacion()
    {
        return $this->belongsTo(VisualizacionesPortafolio::class, 'id_visualizacion_portafolio', 'id_visualizacion_portafolio');
    }
}