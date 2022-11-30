<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Setup\Domain\Movie;

/**
 * Actor class as DTO/ValueObject.
 *
 * To deserialize Api response
 * Make some compare
 */
class Actor
{
    public const ACTOR_POPULARITY_MIN = 5;

    /** Actor id (API side) */
    private int $external_id;

    /** Actor name */
    private string $name;

    /** Actor picture path */
    private ?string $picture;

    /** Actor popularity */
    private float $popularity;

    public function getExternalId(): int
    {
        return $this->external_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPicture(): string
    {
        return $this->picture;
    }

    public function getPopularity(): float
    {
        return $this->popularity;
    }

    public function setExternalId(int $external_id): self
    {
        $this->external_id = $external_id;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function setPopularity(float $popularity): self
    {
        $this->popularity = $popularity;

        return $this;
    }

    public function isSameAs(self $actor): bool
    {
        return $this->external_id === $actor->external_id;
    }

    /**
     * Is the actor valid to be used for game ?
     */
    public function isValid(): bool
    {
        // A minimum of popularity is required for an actor
        if ($this->getPopularity() < self::ACTOR_POPULARITY_MIN) {
            return false;
        }

        return true;
    }
}
