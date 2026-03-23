<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaHabilidad extends Model
{
    use HasFactory;

    protected $table = 'categoria_habilidad';
    protected $primaryKey = 'id_categoria_habilidad';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nombre'];

    public function habilidades()
    {
        return $this->hasMany(Habilidad::class, 'id_categoria_habilidad', 'id_categoria_habilidad');
    }
}