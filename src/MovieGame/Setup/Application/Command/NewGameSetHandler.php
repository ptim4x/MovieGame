<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Setup\Application\Command;

use App\MovieGame\Setup\Domain\Api\MovieApiService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Handler for dispatched message NewGameSetCommand.
 */
#[AsMessageHandler]
class NewGameSetHandler
{
    public function __construct(private MovieApiService $movieApiService)
    {
    }

    public function __invoke(NewGameSetCommand $command): void
    {
        $questionSetSize = $command->getSetSize();
        dump('$questionSetSize='.$questionSetSize);

        $movies = $this->movieApiService->getMovieSet(40);
        dump('count($movies)='.\count($movies));

        $people = $this->movieApiService->getPeopleSet(40);
        dump('count($people)='.\count($people));
    }
}
