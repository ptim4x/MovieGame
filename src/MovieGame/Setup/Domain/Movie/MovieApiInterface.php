<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Setup\Domain\Movie;

/**
 * Interface to be implemented by some Movie API
 * into infrastructure directory.
 */
interface MovieApiInterface
{
    /**
     * Make Api call for popular movies.
     *
     * @return Movie[]
     */
    public function getPopularMovies(int $page): array;

    /**
     * Make Api call for popular actor.
     *
     * @return Actor[]
     */
    public function getPopularActor(int $page): array;

    /**
     * Make Api call for popular actor
     * who perform in the movie with $movieId as Api movie id.
     *
     * @return Actor[]
     */
    public function getMovieActors(int $movieId): array;
}
