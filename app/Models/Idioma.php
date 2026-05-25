<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{
    protected $table = 'idioma';
    protected $primaryKey = 'id_idioma';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['nombre'];

    public function portafolios()
    {
        return $this->belongsToMany(Portafolio::class, 'portafolio_idioma', 'id_idioma', 'id_portafolio');
    }
}