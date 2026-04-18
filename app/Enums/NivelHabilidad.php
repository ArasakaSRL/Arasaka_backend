<?php

namespace App\Enums;

use App\Enums\Concerns\Enumutils;

enum NivelHabilidad: string
{
    use Enumutils;

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