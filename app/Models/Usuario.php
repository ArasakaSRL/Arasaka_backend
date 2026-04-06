<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use App\Notifications\VerificarCorreoNotification;
use App\Notifications\RestablecerContrasenaNotification;

class Usuario extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nombre', 'apellido', 'correo', 'password',
        'descripcion_laboral', 'url_foto', 'estado', 'verificacion_email',
    ];

    protected $hidden = ['password'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->id_usuario) {
                $model->id_usuario = (string) Str::uuid();
            }
        });
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerificarCorreoNotification());
    }

    public function getEmailForVerification()
    {
        return $this->correo;
    }

    public function hasVerifiedEmail()
    {
        return !is_null($this->verificacion_email);
    }

    public function markEmailAsVerified()
    {
        return $this->forceFill(['verificacion_email' => now()])->save();
    }

    public function getEmailForPasswordReset(): string
    {
        return $this->correo;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new RestablecerContrasenaNotification($token));
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
