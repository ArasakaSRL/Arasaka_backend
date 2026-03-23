<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlImagenProyecto extends Model
{
    use HasFactory;

    protected $table = 'url_imagen_proyecto';
    protected $primaryKey = 'id_url_imagen_proyecto';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_proyecto', 'url_imagen'];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto', 'id_proyecto');
    }
}