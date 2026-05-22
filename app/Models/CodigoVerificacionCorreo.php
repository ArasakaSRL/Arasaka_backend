<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CodigoVerificacionCorreo extends Model
{
    protected $table = 'codigo_verificacion_correo';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'id_usuario', 'correo_nuevo', 'codigo', 'expira_en'];

    protected $casts = ['expira_en' => 'datetime'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($model) => $model->id = (string) Str::uuid());
    }
}
