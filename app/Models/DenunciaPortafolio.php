<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DenunciaPortafolio extends Model
{
    use HasFactory;

    protected $table = 'denuncia_portafolio';
    protected $primaryKey = 'id_denuncia_portafolio';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_portafolio',
        'id_etiqueta_denuncia',
        'motivo',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->id_denuncia_portafolio) {
                $model->id_denuncia_portafolio = (string) Str::uuid();
            }
        });
    }

    public function portafolio()
    {
        return $this->belongsTo(Portafolio::class, 'id_portafolio', 'id_portafolio');
    }

    public function etiqueta()
    {
        return $this->belongsTo(EtiquetaDenuncia::class, 'id_etiqueta_denuncia', 'id_etiqueta_denuncia');
    }
}
