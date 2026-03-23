<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telefono extends Model
{
    protected $table = 'telefono';
    protected $primaryKey = 'id_telefono';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['id_usuario', 'telefono'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}