<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Setup\Domain\Shared;

class RandomUnique
{
    public function __construct(
        /** Minimum random number */
        private int $min,
        /** Minimum random number */
        private int $max,
        /** @var int[] */
        private array $numberHistory = []
    ) {
    }

    /**
     * Generate a unique random number.
     */
    public function next(): int
    {
        do {
            $ramdomNumber = Random::int($this->min, $this->max);
        } while (
            \in_array($ramdomNumber, $this->numberHistory, true)
            && \count($this->numberHistory) < $this->max
        );

        $this->numberHistory[] = $ramdomNumber;

        return $ramdomNumber;
    }

    public function getMin(): int
    {
        return $this->min;
    }

    public function getMax(): int
    {
        return $this->max;
    }
}
