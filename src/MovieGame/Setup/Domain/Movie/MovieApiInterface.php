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
     * Make Api call for popular people.
     *
     * @return People[]
     */
    public function getPopularPeople(int $page): array;

    /**
     * Make Api call for popular people
     * who perform in the movie with $movieId as Api movie id.
     *
     * @return People[]
     */
    public function getMovieActors(int $movieId): array;
}
