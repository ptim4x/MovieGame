<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Setup\Domain\Movie;

use App\MovieGame\Setup\Domain\Shared\RandomUnique;

/**
 * Api domain service class for easy use of a movie Api.
 */
class MovieApiService
{
    /** Api Movie page counter */
    private RandomUnique $moviePage;

    /** Api Actor page counter */
    private RandomUnique $actorPage;

    /** Paginated Api Movie data set */
    private ApiResult $movieSet;

    /** Paginated Api Actor data set */
    private ApiResult $actorSet;

    public function __construct(private MovieApiInterface $movieApi)
    {
        $this->moviePage = new RandomUnique(min: 1, max: 500);
        $this->actorPage = new RandomUnique(min: 1, max: 100);

        $this->movieSet = new ApiResult();
        $this->actorSet = new ApiResult();
    }

    /**
     * Once api call for several Movie
     * Each movie include popular actors who perform in it.
     *
     * @return Movie[]
     */
    public function getMovies(): array
    {
        $page = $this->moviePage->next();
        $movies = $this->movieApi->getPopularMovies($page);
        $validMovies = [];

        // Add Actors to each movie and validate movies
        foreach ($movies as $movie) {
            $actors = $this->movieApi->getMovieActors($movie->getExternalId());
            $movie->setActors($actors);

            // Add only valid movies
            if ($movie->isValid()) {
                $validMovies[] = $movie;
            }
        }

        return $validMovies;
    }

    /**
     * Many api call for Movie until result reach $setSize.
     *
     * @return Movie[]
     */
    public function getMovieSet(int $setSize): array
    {
        do {
            $movies = $this->getMovies();
            $this->movieSet->addResult($movies);
        } while ($this->movieSet->getResultCount() < $setSize);

        return $this->movieSet->getResultLimited($setSize);
    }

    /**
     * Many api call for Actor until result reach $setSize.
     *
     * @return Actor[]
     */
    public function getActorSet(int $setSize): array
    {
        do {
            $page = $this->actorPage->next();
            $actor = $this->movieApi->getPopularActor($page);
            $this->actorSet->addResult($actor);
        } while ($this->actorSet->getResultCount() < $setSize);

        return $this->actorSet->getResultLimited($setSize);
    }
}
