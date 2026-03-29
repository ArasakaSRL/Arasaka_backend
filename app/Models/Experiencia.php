<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experiencia extends Model
{
    use HasFactory;

    protected $table = 'experiencia';
    protected $primaryKey = 'id_experiencia';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false; 
    protected $fillable = [
        'id_portafolio',
        'id_tipo_experiencia',
        'cargo',
        'nombre_organizacion',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'vigente',
    ];

    protected $casts = [
        'vigente' => 'boolean',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function portafolio()
    {
        return $this->belongsTo(Portafolio::class, 'id_portafolio', 'id_portafolio');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoExperiencia::class, 'id_tipo_experiencia', 'id_tipo_experiencia');
    }
}