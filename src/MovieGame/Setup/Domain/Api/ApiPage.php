<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Setup\Domain\Api;

/**
 * ApiPage class used as Api paginator helper.
 */
class ApiPage
{
    public function __construct(
        /** Minimum fetchable page number */
        private int $minPage = 1,
        /** Maximum fetchable page number */
        private int $maxPage = 500,
        /** @var int[] Page number already fetched array */
        private array $pageHistory = [],
    ) {
    }

    /**
     * Generate a random page number not already choosen.
     */
    public function getNextPage(): int
    {
        do {
            $ramdomNumber = random_int($this->minPage, $this->maxPage);
        } while (\in_array($ramdomNumber, $this->pageHistory, true));
        $this->pageHistory[] = $ramdomNumber;

        return $ramdomNumber;
    }
}
