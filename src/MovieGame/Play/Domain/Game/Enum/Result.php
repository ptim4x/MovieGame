<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Play\Domain\Game\Enum;

enum Result: string
{
    case Win = 'win';

    case Loose = 'loose';
}
