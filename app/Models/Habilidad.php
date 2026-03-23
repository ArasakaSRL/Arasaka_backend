<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habilidad extends Model
{
    use HasFactory;

    protected $table = 'habilidad';
    protected $primaryKey = 'id_habilidad';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_portafolio',
        'id_categoria_habilidad',
        'id_nivel_habilidad',
        'nombre',
    ];

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
        return $this->hasMany(Tecnologia::class, 'id_habilidad', 'id_habilidad');
    }
}