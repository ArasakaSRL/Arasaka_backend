<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InteraccionExperiencia extends Model
{
    protected $table = 'interaccion_experiencia';
    
    protected $primaryKey = 'id_interaccion';
    
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;
}
