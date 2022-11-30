<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Setup\Domain\Question;

use App\MovieGame\Setup\Domain\Movie\Actor;
use App\MovieGame\Setup\Domain\Movie\Movie;

/**
 * Question class as DTO/ValueObject.
 *
 * To be stored for game play
 */
class Question
{
    private string $hash;

    private function __construct(
        private Actor $actor,
        private Movie $movie,
        private bool $answer,
    ) {
        $this->generateHash();
    }

    public static function create(
        Actor $actor,
        Movie $movie,
        bool $answer,
    ): self {
        return new self($actor, $movie, $answer);
    }

    public function getActor(): Actor
    {
        return $this->actor;
    }

    public function getMovie(): Movie
    {
        return $this->movie;
    }

    public function getAnswer(): bool
    {
        return $this->answer;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * Is it the same question ?
     * True if same actor and same movie.
     */
    public function isSameAs(self $question): bool
    {
        return $this->movie->isSameAs($question->getMovie())
            && $this->actor->isSameAs($question->getActor());
    }

    /**
     * Question hash generator.
     */
    private function generateHash(): string
    {
        return $this->hash = sha1(uniqid(more_entropy: true));
    }
}
