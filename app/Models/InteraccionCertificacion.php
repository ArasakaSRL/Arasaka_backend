<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InteraccionCertificacion extends Model
{
    protected $table = 'interaccion_certificacion';
    
    protected $primaryKey = 'id_interaccion';
    
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false; 
}