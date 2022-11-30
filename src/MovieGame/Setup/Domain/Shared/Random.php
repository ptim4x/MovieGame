<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Setup\Domain\Shared;

class Random
{
    /**
     * Generate a random number.
     */
    public static function int(int $min, int $max): int
    {
        return random_int($min, $max);
    }

    /**
     * Generate a random boolean.
     */
    public static function bool(): bool
    {
        return 0 === self::int(min: 0, max: 1) % 2;
    }
}
