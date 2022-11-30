<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Setup\Domain\Movie;

/**
 * ApiResult class used as Api result helper.
 */
class ApiResult
{
    public function __construct(
        /** @var mixed[] Api call result deserialized */
        private array $result = [],
    ) {
    }

    /**
     * Set the value of result.
     *
     * @param mixed[] $result
     */
    public function setResult(array $result): self
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get the value of result.
     *
     * @param mixed[] $result
     */
    public function addResult(array $result): self
    {
        $this->setResult(array_merge($this->getResult(), $result));

        return $this;
    }

    /**
     * Get the value of result.
     *
     * @return mixed[]
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * Get the value of result, as array truncated to $sizeLimit.
     *
     * @return mixed[]
     */
    public function getResultLimited(int $sizeLimit): array
    {
        return \array_slice($this->getResult(), 0, $sizeLimit);
    }

    /**
     * Get the result count.
     */
    public function getResultCount(): int
    {
        return \count($this->result);
    }
}
