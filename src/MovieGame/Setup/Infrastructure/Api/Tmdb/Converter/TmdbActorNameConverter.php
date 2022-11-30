<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Setup\Infrastructure\Api\Tmdb\Converter;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class TmdbActorNameConverter implements NameConverterInterface
{
    /** N/A : Normailizer never used */
    public function normalize(string $propertyName): string
    {
        return $propertyName;
    }

    /**
     * Modify Actor parameter name when denormalize (array=>object).
     */
    public function denormalize(string $propertyName): string
    {
        // All fields model even if converted to same name, to be exhaustive
        switch ($propertyName) {
            case 'id':
                return 'external_id';

            case 'name':
                return 'name';

            case 'profile_path':
                return 'picture';

            case 'popularity':
                return 'popularity';
        }

        return $propertyName;
    }
}
