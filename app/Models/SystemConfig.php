<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemConfig extends Model
{
    protected $table = 'system_config';
    public $timestamps = false;

    protected $fillable = [
        'denuncias_advertencia',
        'denuncias_suspension',
        'portafolios_advertencia',
        'portafolios_suspension',
        'dias_suspension_portafolio',
        'dias_suspension_usuario',
    ];

    public static function get(): self
    {
        return self::firstOrCreate([], [
            'denuncias_advertencia'      => 8,
            'denuncias_suspension'       => 10,
            'portafolios_advertencia'    => 2,
            'portafolios_suspension'     => 3,
            'dias_suspension_portafolio' => 30,
            'dias_suspension_usuario'    => 30,
        ]);
    }
}
