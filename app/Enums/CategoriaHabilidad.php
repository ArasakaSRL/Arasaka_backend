<?php

namespace App\Enums;

use App\Enums\Concerns\Enumutils;

enum CategoriaHabilidad: string
{
    use Enumutils;

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