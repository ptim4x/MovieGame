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
use App\MovieGame\Setup\Domain\Shared\Random;
use App\MovieGame\Setup\Domain\Shared\RandomUnique;

/**
 * QuestionCreator class which manage to create question with logic choices.
 */
class QuestionCreator
{
    /** Choose actor only in first movie position to be more famous */
    private const ACTOR_CHOOSE_MAX_POS = 5;

    /** Current movie key sequence to pass through the movie set*/
    private int $currentMovieKey = 0;

    /** Random movie key used if current movie key sequence reach the set limit */
    private RandomUnique $randomMovieKey;

    /** Random movie key used to find actor not performing in a movie */
    private RandomUnique $randomOtherMovieKey;

    /** Random actor key used to find actor not performing in a movie, to improve randomness */
    private RandomUnique $randomActorKey;

    public function __construct(
        /** @var Movie[] List of movie with actors */
        private array $movieSet,
        /** @var Actor[] List of actor */
        private array $actorSet,
        // private ManagerRegistry $doctrine
    ) {
        $movieSetSize = \count($this->movieSet) - 1;
        $actorSetSize = \count($this->actorSet) - 1;
        $this->randomMovieKey = new RandomUnique(min: 0, max: $movieSetSize);
        $this->randomOtherMovieKey = new RandomUnique(min: 0, max: $movieSetSize);
        $this->randomActorKey = new RandomUnique(min: 0, max: $actorSetSize);
    }

    public function create(): Question
    {
        $movie = $this->getNextMovie() ?: $this->getRandomMovie();
        $answer = $this->chooseAnswer();

        $actor = $answer ?
                $this->chooseActorIn($movie) :
                $this->chooseActorNotIn($movie);

        return Question::create($actor, $movie, $answer);
    }

    /**
     * Get the next movie from the movieSet and incremment the currentMovieKey.
     */
    private function getNextMovie(): ?Movie
    {
        if ($this->currentMovieKey < \count($this->movieSet)) {
            return $this->movieSet[$this->currentMovieKey++];
        }

        return null;
    }

    /**
     * Get a random movie from the movieSet.
     */
    private function getRandomMovie(): Movie
    {
        return $this->movieSet[$this->randomMovieKey->next()];
    }

    /**
     * Get a random movie from the movieSet.
     */
    private function getRandomOtherMovie(): Movie
    {
        return $this->movieSet[$this->randomOtherMovieKey->next()];
    }

    /**
     * Choose an answer for the question.
     */
    private function chooseAnswer(): bool
    {
        return Random::bool();
    }

    /**
     * Choose an actor seen in this movie.
     */
    private function chooseActorIn(Movie $movie): ?Actor
    {
        $actors = $movie->getActors();

        if (0 === \count($actors)) {
            return null;
        }

        // Limit the random max key to get more popular movie actor
        $maxKey = \count($actors) > self::ACTOR_CHOOSE_MAX_POS ? self::ACTOR_CHOOSE_MAX_POS : \count($actors) - 1;
        $randomKey = Random::int(0, $maxKey);

        return $actors[$randomKey];
    }

    /**
     * Choose an actor not seen in this movie.
     */
    private function chooseActorNotIn(Movie $movie): Actor
    {
        do {
            // Tw ways to choose actor not performing in this movie
            if (Random::bool()) {
                // Search actor in other movies
                $otherMovie = $this->getRandomOtherMovie();
                $actor = $this->chooseActorIn($otherMovie);
            } else {
                // Search actor in standalone actor list
                $actor = $this->actorSet[$this->randomActorKey->next()];
            }
        } while ($movie->hasActor($actor));

        return $actor;
    }
}
