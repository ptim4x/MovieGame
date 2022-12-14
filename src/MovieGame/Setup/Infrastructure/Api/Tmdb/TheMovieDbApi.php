<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Setup\Infrastructure\Api\Tmdb;

use App\MovieGame\Setup\Domain\Movie\Actor;
use App\MovieGame\Setup\Domain\Movie\Movie;
use App\MovieGame\Setup\Domain\Movie\MovieApiInterface;
use App\MovieGame\Setup\Infrastructure\Api\Tmdb\Converter\TmdbActorNameConverter;
use App\MovieGame\Setup\Infrastructure\Api\Tmdb\Converter\TmdbMovieNameConverter;
use LanguageDetector\LanguageDetector;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * TheMovieDbApi class that implement MovieApiInterface.
 */
class TheMovieDbApi implements MovieApiInterface
{
    public const PATH = '/3';
    public const ACTOR_DEPARTEMENT = 'Acting';
    public const MOVIE_ANIMATION_GENRE_ID = 16;
    // LanguageDetector lib not very relevant for european languages (mostly because a title has few words)
    // THus, a lot of languages are allowed
    public const MOVIE_LANGUAGE_ALLOWED = ['fr', 'en', 'it', 'es', 'de', 'tl', 'pt', 'id', 'so', 'hr', 'sw', 'nl', 'da', 'af', 'lt', 'fi', 'i-klingon', 'sq', 'no'];

    private SerializerInterface $movieSerializer;
    private SerializerInterface $actorSerializer;
    private LanguageDetector $languageDetector;

    public function __construct(
        private HttpClientInterface $tmdbClient,
        private string $apiPhotoBaseUri,
    ) {
        // Movie Denormalize (array=>object) with parameter name modifying
        $tmdbMovieNormalizer = new ObjectNormalizer(null, new TmdbMovieNameConverter());
        $this->movieSerializer = new Serializer(
            [$tmdbMovieNormalizer, new GetSetMethodNormalizer(), new ArrayDenormalizer()],
            [new JsonEncoder()]
        );

        // Actor Denormalize (array=>object) with parameter name modifying
        $tmdbActorNormalizer = new ObjectNormalizer(null, new TmdbActorNameConverter());
        $this->actorSerializer = new Serializer(
            [$tmdbActorNormalizer, new GetSetMethodNormalizer(), new ArrayDenormalizer()],
            [new JsonEncoder()]
        );

        $this->languageDetector = new LanguageDetector();
    }

    /**
     * Make Api call for popular movies.
     */
    public function getPopularMovies(int $page = 1): array
    {
        $results = $this->call('movie/popular', ['page' => $page])['results'];

        $results = $this->filterMovies($results);

        $results = $this->updatePictureWithImageBasedUri($results);

        return $this->movieSerializer->deserialize(json_encode($results), Movie::class.'[]', 'json');
    }

    /**
     * Make Api call for popular actor.
     */
    public function getPopularActor(int $page = 1): array
    {
        $person = $this->call('person/popular', ['page' => $page])['results'];

        $actors = $this->filterActor($person);

        $actors = $this->updatePictureWithImageBasedUri($actors);

        return $this->actorSerializer->deserialize(json_encode($actors), Actor::class.'[]', 'json');
    }

    /**
     * Make Api call for popular actor
     * who perform in the movie with $movieId as Api movie id.
     */
    public function getMovieActors(?int $movieId): array
    {
        $casting = $this->call("/movie/{$movieId}/credits")['cast'];

        $actors = $this->filterActor($casting);

        $actors = $this->updatePictureWithImageBasedUri($actors);

        return $this->actorSerializer->deserialize(json_encode($actors), Actor::class.'[]', 'json');
    }

    /**
     * The Api call method.
     *
     * TMDB base_uri and api_key already defined into framework config
     * scoped client tmdb.client autowired with $tmdbClient
     *
     * @param array<string, int> $query
     *
     * @return array<string, mixed>
     */
    public function call(string $path, array $query = [], string $method = 'GET'): array
    {
        $response = $this->tmdbClient->request(
            $method,
            self::PATH.'/'.$path,
            ['query' => $query]
        );

        return $response->toArray();
    }

    /**
     * Popular actor filter from people.
     *
     * @param array<int, array<string, mixed>> $people
     *
     * @return array<int, array<string, mixed>>
     */
    private function filterActor(array $people): array
    {
        $filterFn = fn ($person) => self::ACTOR_DEPARTEMENT === $person['known_for_department'];

        return array_filter($people, $filterFn);
    }

    /**
     * Filter movies genre Animation.
     *
     * @param array<int, array<string, mixed>> $movies
     *
     * @return array<int, array<string, mixed>>
     */
    private function filterMovies(array $movies): array
    {
        // Animation movie filter function
        $animationfilterFn = fn ($movie) => !\in_array(self::MOVIE_ANIMATION_GENRE_ID, $movie['genre_ids'], true);

        // Languages movie filter function
        $languagesfilterFn = function ($movie) {
            // Exclude eastern movies whose title is not translated
            $countryCode = $this->languageDetector->evaluate($movie['title'])->getLanguage();

            return \in_array($countryCode->getCode(), self::MOVIE_LANGUAGE_ALLOWED, true);
        };

        $filterFn = fn ($movie) => $animationfilterFn($movie) && $languagesfilterFn($movie);

        return array_filter($movies, $filterFn);
    }

    /**
     * Update all pictures filemane with the api photo base uri
     * => Done here to be store !
     * thus, we can unplug this api and plug another one without full uri picture issue.
     *
     * @param array<int, array<string, mixed>> $mixedEntities
     *
     * @return array<int, array<string, mixed>>
     */
    private function updatePictureWithImageBasedUri(array $mixedEntities): array
    {
        $apiPhotoBaseUri = $this->apiPhotoBaseUri;

        return array_map(function ($mixed) use ($apiPhotoBaseUri) {
            foreach ($mixed as $field => $value) {
                if (\in_array($field, ['profile_path', 'poster_path'], true)) {
                    $mixed[$field] = $apiPhotoBaseUri.$value;
                }
            }

            return $mixed;
        }, $mixedEntities);
    }
}
