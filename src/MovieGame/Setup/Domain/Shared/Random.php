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

    public static function plouf($max = 2): bool
    {
        return self::int(min: 1, max: $max) % 2 === 0;
    }
}
