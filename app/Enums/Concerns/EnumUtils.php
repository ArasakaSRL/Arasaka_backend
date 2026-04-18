<?php

declare(strict_types=1);

namespace App\Enums\Concerns;

trait Enumutils
{
    /**
     * Get the enum cases as an array of values.
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array{
        return array_combine(
            array_map(fn ($case) => $case->value, self::cases()),
            array_map(fn ($case) => $case->name, self::cases())
        ) ?: [];
    }
}