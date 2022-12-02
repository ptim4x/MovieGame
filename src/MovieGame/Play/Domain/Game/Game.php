<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Play\Domain\Game;

/**
 * Game Question class as DTO.
 */
class Game
{
    public function __construct(
        private int $questionId,
        private string $actorName,
        private string $actorPicture,
        private string $movieTitle,
        private string $moviePicture,
        private string $hash,
    ) {
    }

    /**
     * Get the value of questionId.
     */
    public function getQuestionId(): int
    {
        return $this->questionId;
    }

    /**
     * Get the value of actorName.
     */
    public function getActorName(): string
    {
        return $this->actorName;
    }

    /**
     * Get the value of actorPicture.
     */
    public function getActorPicture(): string
    {
        return $this->actorPicture;
    }

    /**
     * Get the value of movieTitle.
     */
    public function getMovieTitle(): string
    {
        return $this->movieTitle;
    }

    /**
     * Get the value of moviePicture.
     */
    public function getMoviePicture(): string
    {
        return $this->moviePicture;
    }

    /**
     * Get the value of hash.
     */
    public function getHash(): string
    {
        return $this->hash;
    }
}
