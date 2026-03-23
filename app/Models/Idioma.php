<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{
    protected $table = 'idioma';
    protected $primaryKey = 'id_idioma';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['nombre'];

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'usuario_idioma', 'id_idioma', 'id_usuario');
    }
}