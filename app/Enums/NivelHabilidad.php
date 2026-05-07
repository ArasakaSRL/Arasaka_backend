<?php

namespace App\Enums;

use App\Enums\Concerns\EnumUtils;

enum NivelHabilidad: string
{
    use EnumUtils;

    case PRINCIPIANTE = "Principiante";
    case INTERMEDIO = "Intermedio";
    case COMPETENTE = "Competente";
    case AVANZADO = "Avanzado";

    case EXPERTO = "Experto";

    public function label(): string
    {
        return match ($this) {
            self::PRINCIPIANTE => 'Principiante',
            self::INTERMEDIO => 'Intermedio',
            self::COMPETENTE => 'Compentente',
            self::AVANZADO => 'Avanzado',
            self::EXPERTO => 'Experto',
        };
    }
}