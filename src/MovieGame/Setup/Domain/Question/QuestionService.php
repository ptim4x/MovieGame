<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Setup\Domain\Question;

use App\MovieGame\Setup\Domain\Movie\Actor;
use App\MovieGame\Setup\Domain\Movie\Movie;

class QuestionService
{
    public function __construct(
        private string $env,
        private QuestionRepositoryInterface $questionRepository
    ) {
    }

    /**
     * Create a set of question.
     *
     * @param Movie[] $movieSet
     * @param Actor[] $actorSet
     */
    public function createGameSet(array $movieSet, array $actorSet, int $setSize): void
    {
        $questionCreator = new QuestionCreator($movieSet, $actorSet);

        // Generate entity Question set
        $questions = [];
        $answerYes = $answerNo = 0;
        for ($i = 1; $i <= $setSize; ++$i) {
            $question = $questionCreator->create();
            $questions[] = $question;
            $question->getAnswer() ? $answerYes++ : $answerNo++;
        }

        // Store all Question
        $this->questionRepository->storeMany($questions);

        --$i;
        echo "END: {$i} questions created ! {$answerYes} YES answers and {$answerNo} NO answers\n";
    }
}
