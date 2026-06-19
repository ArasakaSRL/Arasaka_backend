<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitante extends Model
{
    protected $table = 'visitante';
    
    protected $primaryKey = 'id_visitante';
    
    // Como usas UUIDs, le decimos a Laravel que no es un entero autoincrementable
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;
}
