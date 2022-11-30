<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Setup\Application\Command;

use App\MovieGame\Setup\Domain\Movie\MovieApiService;
use App\MovieGame\Setup\Domain\Question\QuestionService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Handler for dispatched message NewGameSetCommand.
 */
#[AsMessageHandler]
class NewGameSetHandler
{
    public function __construct(
        private MovieApiService $movieApiService,
        private QuestionService $questionService,
    ) {
    }

    public function __invoke(NewGameSetCommand $command): void
    {
        $questionSetSize = $command->getSetSize();
        echo "BEGIN: Create new game set create with {$questionSetSize} questions...\r\n";

        $movies = $this->movieApiService->getMovieSet($questionSetSize);

        $actors = $this->movieApiService->getActorSet($questionSetSize);

        $this->questionService->createGameSet($movies, $actors, $questionSetSize);
    }
}
