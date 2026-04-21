<?php

namespace App\Enums;

use App\Enums\Concerns\EnumUtils;

enum CategoriaHabilidad: string
{
    use EnumUtils;

    case BLANDA = 'blanda';
    case TECNICA = 'tecnica';

    public function label(): string
    {
        return match ($this) {
            self::BLANDA => 'blanda',
            self::TECNICA => 'tecnica',
        };
    }
}