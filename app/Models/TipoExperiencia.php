<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoExperiencia extends Model
{
    use HasFactory;

    protected $table = 'tipo_experiencia';
    protected $primaryKey = 'id_tipo_experiencia';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nombre'];

    public function experiencias()
    {
        return $this->hasMany(Experiencia::class, 'id_tipo_experiencia', 'id_tipo_experiencia');
    }
}