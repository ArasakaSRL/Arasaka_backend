<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InteraccionProyecto extends Model
{
    protected $table = 'interaccion_proyecto';
    
    protected $primaryKey = 'id_interaccion';
    
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;
}
