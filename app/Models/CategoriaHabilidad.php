<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaHabilidad extends Model
{
    use HasFactory;

    const TECNICA = 'b4e21d3d-e3eb-4006-a7e8-0e720267f4c6';
    const BLANDA = 'dc1131cc-2816-417a-a23f-f01e664f3ac1';

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