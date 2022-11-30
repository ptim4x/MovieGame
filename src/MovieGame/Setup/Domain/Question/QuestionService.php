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
    public function __construct(private string $env)
    {
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

        $answerYes = $answerNo = 0;
        for ($i = 1; $i <= $setSize; ++$i) {
            $question = $questionCreator->create();
            $question->getAnswer() ? $answerYes++ : $answerNo++;

            if ('dev' === $this->env) {
                echo "Question {$i} = ".$question->getActor()->getName().
                    ' play in '.$question->getMovie()->getTitle().
                    ' => '.($question->getAnswer() ? 'YES' : 'NO') . "\n";
            }
        }

        if ('dev' === $this->env) {
            echo "END: {$i} questions created ! {$answerYes} YES answers and {$answerNo} NO answers\n";
        } else {
            $ratio = round($answerYes / $answerNo, 2);
            echo "END: {$i} questions created ! answer YES/NO ratio {$ratio} \n";
        }
    }
}
