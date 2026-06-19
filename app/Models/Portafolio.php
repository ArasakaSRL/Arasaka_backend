<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\DenunciaPortafolio;

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
        'suspendido',
        'suspendido_hasta',
        'descripcion',
        'slug',
        'fecha_creacion',
        'fecha_actualizacion',
        'link_activo',
        'fecha_expiracion_link',
        'duracion_link',
    ];

    protected $casts = [
        'visibilidad' => 'boolean',
        'suspendido'       => 'boolean',
        'suspendido_hasta' => 'datetime',
        'fecha_creacion' => 'date',
        'fecha_actualizacion' => 'date',
        'link_activo' => 'boolean',
        'fecha_expiracion_link' => 'datetime',
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

    public function informacionBasica()
    {
        return $this->hasOne(InformacionBasica::class, 'id_portafolio', 'id_portafolio');
    }

    public function telefonos()
    {
        return $this->hasMany(Telefono::class, 'id_portafolio', 'id_portafolio');
    }

    public function idiomas()
    {
        return $this->belongsToMany(Idioma::class, 'portafolio_idioma', 'id_portafolio', 'id_idioma');
    }

    public function profesiones()
    {
        return $this->belongsToMany(Profesion::class, 'portafolio_profesion', 'id_portafolio', 'id_profesion');
    }
    public function getRouteKeyName()
{
    return 'id_portafolio';
}

    public function denuncias()
    {
        return $this->hasMany(DenunciaPortafolio::class, 'id_portafolio', 'id_portafolio');
    }

    public function visualizaciones()
    {
        return $this->hasMany(VisualizacionesPortafolio::class, 'id_portafolio', 'id_portafolio');
    }
    public function formacion_academica()
    {
        return $this->hasMany(FormacionAcademica::class, 'id_portafolio', 'id_portafolio');
    }
    protected static function boot()
{
    parent::boot();

    static::creating(function ($portafolio) {

        // solo si no viene slug manual
        if (!$portafolio->slug) {

            $slugBase = Str::slug($portafolio->nombre);

            $count = self::where('slug', 'like', "$slugBase%")->count();

            $portafolio->slug = $count
                ? "{$slugBase}-" . ($count + 1)
                : $slugBase;
        }
    });
}
}