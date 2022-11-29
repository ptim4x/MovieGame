<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Setup\Infrastructure\Api\Tmdb\Converter;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class TmdbMovieNameConverter implements NameConverterInterface
{
    /** N/A : Normailizer never used */
    public function normalize(string $propertyName): string
    {
        return $propertyName;
    }

    /**
     * Modify Movie parameter name when denormalize (array=>object).
     */
    public function denormalize(string $propertyName): string
    {
        // All fields model to be exhaustive
        switch ($propertyName) {
            case 'id':
                return 'external_id';

            case 'title':
                return 'title';

            case 'poster_path':
                return 'picture';

            case 'popularity':
                return 'popularity';
        }

        return '';
    }
}
