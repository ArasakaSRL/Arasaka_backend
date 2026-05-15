<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjuntoMensaje extends Model
{
    use HasFactory;

    protected $table = 'adjuntos_mensaje';
    protected $primaryKey = 'id_adjunto';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_adjunto',
        'id_mensaje',
        'nombre_archivo',
        'url_archivo',
        'public_id',
        'tipo_mime',
    ];

    public function mensaje()
    {
        return $this->belongsTo(Mensaje::class, 'id_mensaje', 'id_mensaje');
    }
}
