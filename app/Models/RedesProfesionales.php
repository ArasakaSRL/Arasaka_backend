<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RedesProfesionales extends Model
{
    protected $table = 'redes_profesionales';

    protected $primaryKey = 'id_red_profesional';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [

        'id_portafolio',

        'nombre',

        'url'
    ];
}