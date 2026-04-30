<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    protected $table = 'mensajes';
    protected $primaryKey = 'id_mensaje';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_mensaje',
        'id_remitente',
        'nombre_remitente',
        'correo_remitente',
        'id_destinatario',
        'correo_destinatario',
        'asunto',
        'contenido',
        'leido',
        'fecha_envio',
    ];

    protected $casts = [
        'leido' => 'boolean',
        'fecha_envio' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'id_mensaje';
    }

    public function remitente()
    {
        return $this->belongsTo(Usuario::class, 'id_remitente', 'id_usuario');
    }

    public function destinatario()
    {
        return $this->belongsTo(Usuario::class, 'id_destinatario', 'id_usuario');
    }

    public function adjuntos()
    {
        return $this->hasMany(AdjuntoMensaje::class, 'id_mensaje', 'id_mensaje');
    }
}
