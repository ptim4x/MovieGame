<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Play\Domain\Game\Enum;

enum Reply: string
{
    case Right = 'right';

    case Wrong = 'wrong';

    public function getResult(bool $realAnswer): Result
    {
        return static::getBool($this) === $realAnswer ? Result::Win : Result::Loose;
    }

    private static function getBool(self $value): bool
    {
        return match ($value) {
            Reply::Right => true,
            Reply::Wrong => false,
        };
    }
}
