<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CategoriaCertificacion extends Model
{
    protected $table = 'categoria_certificacion';
    protected $primaryKey = 'id_categoria_certificacion';
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_categoria_certificacion',
        'nombre',
        'descripcion',
        'url_imagen',
    ];
        protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->id_categoria_certificacion = (string) Str::uuid();
            }
        });
    }

    public function certificaciones()
    {
        return $this->hasMany(Certificacion::class, 'id_categoria_certificacion');
    }
}