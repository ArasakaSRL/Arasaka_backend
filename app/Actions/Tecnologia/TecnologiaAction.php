<?php

namespace App\Actions\Tecnologia;

use App\Models\Tecnologia;

class TecnologiaAction
{
    public static function crear(array $data): Tecnologia
    {
        return Tecnologia::create($data);
    }

    public static function actualizar(Tecnologia $tecnologia, array $data): bool
    {
        return $tecnologia->update($data);
    }

    public static function eliminar(Tecnologia $tecnologia): bool
    {
        return $tecnologia->delete();
    }
}