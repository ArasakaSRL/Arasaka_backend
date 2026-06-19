<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InteraccionPerfil extends Model
{
    protected $table = 'interaccion_perfil';
    
    protected $primaryKey = 'id_interaccion';

    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;
}
