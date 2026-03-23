<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tecnologia extends Model
{
    use HasFactory;

    protected $table = 'tecnologias';
    protected $primaryKey = 'id_tecnologia';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_proyecto',
        'id_habilidad',
        'nombre',
        'descripcion',
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto', 'id_proyecto');
    }

    public function habilidad()
    {
        return $this->belongsTo(Habilidad::class, 'id_habilidad', 'id_habilidad');
    }

    public function categorias()
    {
        return $this->hasMany(CategoriaTecnologia::class, 'id_tecnologia', 'id_tecnologia');
    }
}