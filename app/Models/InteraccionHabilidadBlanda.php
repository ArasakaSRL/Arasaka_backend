<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InteraccionHabilidadBlanda extends Model
{
    protected $table = 'interaccion_habilidad_blanda';
    
    protected $primaryKey = 'id_interaccion';
    
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;
}
