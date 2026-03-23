<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelDeHabilidad extends Model
{
    use HasFactory;

    protected $table = 'nivel_de_habilidad';
    protected $primaryKey = 'id_nivel_habilidad';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nivel'];

    public function habilidades()
    {
        return $this->hasMany(Habilidad::class, 'id_nivel_habilidad', 'id_nivel_habilidad');
    }
}