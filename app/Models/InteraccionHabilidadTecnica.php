<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InteraccionHabilidadTecnica extends Model
{
    protected $table = 'interaccion_habilidad_tecnica';

    protected $primaryKey = 'id_interaccion';
    
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;
}
