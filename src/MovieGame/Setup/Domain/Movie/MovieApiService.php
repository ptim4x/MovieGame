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

    /** Api People page counter */
    private RandomUnique $peoplePage;

    /** Paginated Api Movie data set */
    private ApiResult $movieSet;

    /** Paginated Api People data set */
    private ApiResult $peopleSet;

    public function __construct(private MovieApiInterface $movieApi)
    {
        $this->moviePage = new RandomUnique(min: 1, max: 500);
        $this->peoplePage = new RandomUnique(min: 1, max: 100);

        $this->movieSet = new ApiResult();
        $this->peopleSet = new ApiResult();
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
     * Many api call for People until result reach $setSize.
     *
     * @return People[]
     */
    public function getPeopleSet(int $setSize): array
    {
        do {
            $page = $this->peoplePage->next();
            $people = $this->movieApi->getPopularPeople($page);
            $this->peopleSet->addResult($people);
        } while ($this->peopleSet->getResultCount() < $setSize);

        return $this->peopleSet->getResultLimited($setSize);
    }
}
