<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaHabilidad extends Model
{
    use HasFactory;

    const TECNICA = 'a89a8fde-57d9-4ec5-bba1-e9c93662f1a1';
    const BLANDA = '7bea0be0-b617-4a39-9fc6-de4f6b232110';

    protected $table = 'categoria_habilidad';
    protected $primaryKey = 'id_categoria_habilidad';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nombre'];

    public function habilidades()
    {
        return $this->hasMany(Habilidad::class, 'id_categoria_habilidad', 'id_categoria_habilidad');
    }
}