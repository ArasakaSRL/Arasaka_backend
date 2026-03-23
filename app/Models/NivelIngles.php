<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelIngles extends Model
{
    protected $table = 'nivel_ingles';
    protected $primaryKey = 'id_nivel_ingles';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['id_idioma', 'nivel'];

    public function idioma()
    {
        return $this->belongsTo(Idioma::class, 'id_idioma');
    }
}