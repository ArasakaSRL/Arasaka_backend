<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificacion extends Model
{
    use HasFactory;

    protected $table = 'certificacion';
    protected $primaryKey = 'id_certificacion';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_portafolio',
        'titulo',
        'descripcion',
        'institucion_emisora',
        'fecha_obtencion',
        'url_archivo',
    ];

    protected $casts = [
        'fecha_obtencion' => 'date',
    ];

    public function portafolio()
    {
        return $this->belongsTo(Portafolio::class, 'id_portafolio', 'id_portafolio');
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaCertificacion::class, 'id_categoria_certificacion', 'id_categoria_certificacion');
    }
}