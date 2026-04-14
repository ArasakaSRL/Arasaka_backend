<?php

namespace App\Enums;

use App\Enums\Concerns\Enumutils;

enum NivelHabilidad: string
{
    use Enumutils;

    case BASICO = "basico";
    case INTERMEDIO = "intermedio";
    case COMPETENTE = "competente";
    case AVANZADO = "avanzado";

    public function label(): string
    {
        return match ($this) {
            self::BASICO => 'blanda',
            self::INTERMEDIO => 'tecnica',
            self::COMPETENTE => 'compentente',
            self::AVANZADO => 'avanzado',
        };
    }
}