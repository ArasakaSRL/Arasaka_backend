<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedesProfesionales extends Model
{
    use HasFactory;

    protected $table = 'redes_profesionales';
    protected $primaryKey = 'id_red_profesional';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_portafolio',
        'nombre',
        'url',
    ];

    public function portafolio()
    {
        return $this->belongsTo(Portafolio::class, 'id_portafolio', 'id_portafolio');
    }
}