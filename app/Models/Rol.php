<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol';
    protected $primaryKey = 'id_rol';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['nombre_rol', 'descripcion'];

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'usuario_rol', 'id_rol', 'id_usuario');
    }
}