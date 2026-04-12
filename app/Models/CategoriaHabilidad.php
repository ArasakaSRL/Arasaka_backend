<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaHabilidad extends Model
{
    use HasFactory;

    const TECNICA = '03fa2a92-4de1-4a65-95e2-4919a1cd5e50';
    const BLANDA = 'c8d88759-b3cc-4fd9-90dc-456785ffc08e';

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