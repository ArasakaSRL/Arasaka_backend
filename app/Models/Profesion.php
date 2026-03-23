<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesion extends Model
{
    protected $table = 'profesion';
    protected $primaryKey = 'id_profesion';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['nombre', 'descripcion'];

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'usuario_profesion', 'id_profesion', 'id_usuario');
    }
}