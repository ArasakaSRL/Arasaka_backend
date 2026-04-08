<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portafolio extends Model
{
    use HasFactory;

    protected $table = 'portafolio';
    protected $primaryKey = 'id_portafolio';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    
    protected $fillable = [
        'id_portafolio',
        'id_usuario',
        'nombre',
        'visibilidad',
        'descripcion',
        'fecha_creacion',
        'fecha_actualizacion',
    ];

    protected $casts = [
        'visibilidad' => 'boolean',
        'fecha_creacion' => 'date',
        'fecha_actualizacion' => 'date',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class, 'id_portafolio', 'id_portafolio');
    }

    public function habilidades()
    {
        return $this->hasMany(Habilidad::class, 'id_portafolio', 'id_portafolio');
    }

    public function experiencias()
    {
        return $this->hasMany(Experiencia::class, 'id_portafolio', 'id_portafolio');
    }

    public function servicios()
    {
        return $this->hasMany(Servicio::class, 'id_portafolio', 'id_portafolio');
    }

    public function certificaciones()
    {
        return $this->hasMany(Certificacion::class, 'id_portafolio', 'id_portafolio');
    }

    public function redesProfesionales()
    {
        return $this->hasMany(RedesProfesionales::class, 'id_portafolio', 'id_portafolio');
    }

    public function configuracion()
    {
        return $this->hasOne(ConfiguracionPortafolio::class, 'id_portafolio', 'id_portafolio');
    }

    public function visualizaciones()
    {
        return $this->hasMany(VisualizacionesPortafolio::class, 'id_portafolio', 'id_portafolio');
    }
}