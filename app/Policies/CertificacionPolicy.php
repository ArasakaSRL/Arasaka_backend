<?php

namespace App\Policies;

use App\Models\Usuario;
use App\Models\Certificacion;

class CertificacionPolicy
{
    private function perteneceAlUsuario(Usuario $user, Certificacion $certificacion)
    {
        return $user->portafolio
            && $certificacion->id_portafolio === $user->portafolio->id_portafolio;
    }

    public function viewAny(Usuario $user)
    {
        return $user->portafolio != null;
    }

    public function create(Usuario $user)
    {
        return $user->portafolio != null;
    }

    public function view(Usuario $user, Certificacion $certificacion)
    {
        return $this->perteneceAlUsuario($user, $certificacion);
    }

    public function update(Usuario $user, Certificacion $certificacion)
    {
        return $this->perteneceAlUsuario($user, $certificacion);
    }

    public function delete(Usuario $user, Certificacion $certificacion)
    {
        return $this->perteneceAlUsuario($user, $certificacion);
    }
}