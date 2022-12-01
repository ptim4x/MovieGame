<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Play\Domain\Game\Exception;

class GameAnswerParamRequiredException extends \DomainException
{
    protected $message = 'Post parameter [answer] required.';
}
