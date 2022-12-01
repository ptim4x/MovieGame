<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Play\Domain\Game;

interface GameRepositoryInterface
{
    /**
     * Find next game question.
     */
    public function findNextGameQuestion(): ?Game;

    /**
     * Find by hash the game answer value.
     *
     * @throws \DomainException
     */
    public function findGameAnswerValueByHash(string $hash): bool;

    /**
     * Set by hash the game question answered.
     *
     * @throws \DomainException
     */
    public function setGameQuestionAnsweredByHash(string $hash): void;
}
