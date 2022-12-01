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

    private SerializerInterface $movieSerializer;
    private SerializerInterface $actorSerializer;

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
    }

    /**
     * Make Api call for popular movies.
     */
    public function getPopularMovies(int $page = 1): array
    {
        $results = $this->call('movie/popular', ['page' => $page])['results'];

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
