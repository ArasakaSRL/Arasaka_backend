<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoProyecto extends Model
{
    use HasFactory;

    protected $table = 'estado_proyecto';
    protected $primaryKey = 'id_estado_proyecto';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_proyecto', 'estado'];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto', 'id_proyecto');
    }
}