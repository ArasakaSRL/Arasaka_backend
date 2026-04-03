<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyecto';
    protected $primaryKey = 'id_proyecto';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_proyecto',
        'id_portafolio',
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'url_demo',
        'url_github',
        'destacado',
    ];

    protected function casts(): array {
        return [
            'destacado' => 'boolean',
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
        ];
    }

    public function portafolio()
    {
        return $this->belongsTo(Portafolio::class, 'id_portafolio', 'id_portafolio');
    }

    public function estados()
    {
        return $this->hasMany(EstadoProyecto::class, 'id_proyecto', 'id_proyecto');
    }

    public function imagenes()
    {
        return $this->hasMany(UrlImagenProyecto::class, 'id_proyecto', 'id_proyecto');
    }

   public function tecnologias()
{
    return $this->belongsToMany(
        Tecnologia::class,
        'proyecto_tecnologia',
        'id_proyecto',
        'id_tecnologia'
    );
}
}