<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtiquetaDenuncia extends Model
{
    use HasFactory;

    protected $table = 'etiqueta_denuncia';
    protected $primaryKey = 'id_etiqueta_denuncia';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];

    public function denuncias()
    {
        return $this->hasMany(DenunciaPortafolio::class, 'id_etiqueta_denuncia', 'id_etiqueta_denuncia');
    }
}
