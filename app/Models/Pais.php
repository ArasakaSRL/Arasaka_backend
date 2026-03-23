<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'pais';
    protected $primaryKey = 'id_pais';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['id_usuario', 'nombre'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}