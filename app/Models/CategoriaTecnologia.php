<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaTecnologia extends Model
{
    use HasFactory;

    protected $table = 'categoria_tecnologia';
    protected $primaryKey = 'id_categoria_tecnologia';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_tecnologia',
        'nombre',
    ];

    public function tecnologia()
    {
        return $this->belongsTo(Tecnologia::class, 'id_tecnologia', 'id_tecnologia');
    }
}