<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class Usuario extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'password',
        'biografia',
        'url_foto',
        'estado',
        'verificacion_email'
    ];

    protected $hidden = [
        'password'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id_usuario) {
                $model->id_usuario = (string) Str::uuid();
            }
        });
    }

    public function getEmailForPasswordReset(): string
    {
        return $this->correo;
    }

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'usuario_rol', 'id_usuario', 'id_rol');
    }

    public function telefonos()
    {
        return $this->hasMany(Telefono::class, 'id_usuario');
    }

    public function pais()
    {
        return $this->hasOne(Pais::class, 'id_usuario');
    }

    public function profesiones()
    {
        return $this->belongsToMany(Profesion::class, 'usuario_profesion', 'id_usuario', 'id_profesion');
    }

    public function idiomas()
    {
        return $this->belongsToMany(Idioma::class, 'usuario_idioma', 'id_usuario', 'id_idioma');
    }
}