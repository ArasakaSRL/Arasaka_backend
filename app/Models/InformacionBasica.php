<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InformacionBasica extends Model
{
    use HasFactory;

    protected $table = 'informacion_basica';
    protected $primaryKey = 'id_informacion_basica';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_informacion_basica',
        'id_portafolio',
        'nombre_completo',
        'gmail',
        'contrasena',
        'pais',
        'foto_perfil',
        'foto_perfil_public_id',
        'biografia',
    ];

    protected $hidden = [
        'contrasena',
    ];

    public function portafolio()
    {
        return $this->belongsTo(Portafolio::class, 'id_portafolio', 'id_portafolio');
    }
}
