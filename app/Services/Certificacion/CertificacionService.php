<?php

namespace App\Services\Certificacion;
use App\Models\Certificacion;
use Illuminate\Support\Str;

class CertificacionService {
    public function crear($data ,$idPortafolio){
        return Certificacion::create([
            'id_certificacion' => Str::uuid(),
            'id_portafolio' => $idPortafolio,
            ...$data
        ]);
    }

    public function actualizar(Certificacion $certificacion, $data){
        $certificacion->update($data);
        return $certificacion;
    }

    public function eliminar(Certificacion $certificacion){
        $certificacion->delete();
    }
}