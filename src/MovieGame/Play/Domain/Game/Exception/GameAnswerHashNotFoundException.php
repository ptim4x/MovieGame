<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Play\Domain\Game\Exception;

class GameAnswerHashNotFoundException extends \DomainException
{
    public function __construct(string $message)
    {
        $this->message = 'Answer ressource with hash ['.$message.'] not found.';
    }
}
