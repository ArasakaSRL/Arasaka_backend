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
    public $timestamps = false;
    
    protected $fillable = [
        'id_habilidad',
        'nombre',
        'descripcion',
        'logo',
    ];

     public function proyectos()
    {
        return $this->belongsToMany(
            Proyecto::class,
            'proyecto_tecnologia',
            'id_tecnologia',
            'id_proyecto'
        );
    }

    public function habilidad()
    {
        return $this->belongsTo(Habilidad::class, 'id_habilidad', 'id_habilidad');
    }

    public function categorias()
    {
        return $this->belongsTo(CategoriaTecnologia::class, 'id_tecnologia', 'id_tecnologia');
    }
}