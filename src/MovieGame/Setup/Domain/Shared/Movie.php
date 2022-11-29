<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Setup\Domain\Shared;

/**
 * Movie class as DTO/ValueObject.
 *
 * To deserialize Api response
 * Make some compare
 */
class Movie
{
    /** Movie id (API side) */
    private int $external_id;

    /** Movie title */
    private string $title;

    /** Movie picture path */
    private ?string $picture;

    /** Movie popularity */
    private float $popularity;

    /** @var People[] Actors who perform in it */
    private array $actors;

    public function getExternalId(): int
    {
        return $this->external_id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function getPopularity(): float
    {
        return $this->popularity;
    }

    /** @return People[] */
    public function getActors(): array
    {
        return $this->actors;
    }

    public function hasActor(People $people): bool
    {
        foreach ($this->actors as $actor) {
            if ($actor->isSameAs($people)) {
                return true;
            }
        }

        return false;
    }

    public function setExternalId(int $external_id): self
    {
        $this->external_id = $external_id;

        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    /** @param People[] $actors */
    public function setActors(array $actors): self
    {
        $this->actors = $actors;

        return $this;
    }
}
