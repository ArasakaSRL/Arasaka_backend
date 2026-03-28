<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str ;
class Habilidad extends Model
{
    use HasFactory;

    protected $table = 'habilidad';
    protected $primaryKey = 'id_habilidad';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'id_portafolio',
        'id_categoria_habilidad',
        'id_nivel_habilidad',
        'nombre',
    ];

    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        if (!$model->id_habilidad) {
            $model->id_habilidad = (string) Str::uuid();
        }
    });
}
    public function portafolio()
    {
        return $this->belongsTo(Portafolio::class, 'id_portafolio', 'id_portafolio');
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaHabilidad::class, 'id_categoria_habilidad', 'id_categoria_habilidad');
    }

    public function nivel()
    {
        return $this->belongsTo(NivelDeHabilidad::class, 'id_nivel_habilidad', 'id_nivel_habilidad');
    }

    public function tecnologias()
{
    return $this->belongsToMany(
        Tecnologia::class,
        'habilidades_tiene_tecnologias',
        'id_habilidad',
        'id_tecnologia'
    );
}
}