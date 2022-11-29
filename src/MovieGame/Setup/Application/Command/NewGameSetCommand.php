<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Setup\Application\Command;

/**
 * Request new game data (Question/Answer) set.
 *
 * This command is a simple message to dispatch
 * with symfony bus messenger
 */
class NewGameSetCommand
{
    public function __construct(
        /** Game data (Question/Answer) set size */
        private int $setSize,
    ) {
    }

    /**
     * Get game data (Question/Answer) set size.
     */
    public function getSetSize(): int
    {
        return $this->setSize;
    }
}
