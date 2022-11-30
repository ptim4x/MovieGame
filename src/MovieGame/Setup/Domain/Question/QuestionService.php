<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Setup\Domain\Question;

use App\MovieGame\Setup\Domain\Movie\Movie;
use App\MovieGame\Setup\Domain\Movie\People;

class QuestionService
{
    public function __construct()
    {
    }

    /**
     * Create a set of question.
     *
     * @param Movie[]  $movieSet
     * @param People[] $peopleSet
     */
    public function createGameSet(array $movieSet, array $peopleSet, int $setSize): void
    {
        $questionCreator = new QuestionCreator($movieSet, $peopleSet);

        $answerYes = $answerNo = 0;
        for ($i = 0; $i < $setSize; ++$i) {
            $question = $questionCreator->create();
            $question->getAnswer() ? $answerYes++ : $answerNo++;
        }
        echo "END: {$i} questions created ! {$answerYes} YES answers and {$answerNo} NO answers\r\n";
    }
}