<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MensajeDestacado extends Model
{
    protected $table = 'mensaje_destacado';
    protected $primaryKey = 'id_destacado';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_destacado',
        'id_usuario',
        'id_mensaje',
    ];
}
