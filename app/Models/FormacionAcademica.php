<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class FormacionAcademica extends Model
{
    use HasUuids;

    protected $table = 'formacion_academica';

    protected $primaryKey = 'id_formacion_academica';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_portafolio',
        'institucion',
        'titulo',
        'nivel',
        'fecha_inicio',
        'fecha_fin',
        'descripcion'
    ];
    public function portafolio()
    {
        return $this->belongsTo(Portafolio::class, 'id_portafolio', 'id_portafolio');
    }
}