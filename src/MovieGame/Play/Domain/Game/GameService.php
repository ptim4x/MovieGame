<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Play\Domain\Game;

use App\MovieGame\Play\Domain\Game\Enum\Reply;
use App\MovieGame\Play\Domain\Game\Enum\Result;
use App\MovieGame\Play\Domain\Game\Exception\GameAnswerHashNotFoundException;
use App\MovieGame\Play\Domain\Game\Exception\GameAnswerParamRequiredException;
use App\MovieGame\Play\Domain\Game\Exception\GameAnswerValueInvalid;

class GameService
{
    public function __construct(private GameRepositoryInterface $gameRepository)
    {
    }

    /**
     * Finds a new question not already replied.
     *
     * @return array{
     *      'hash': string,
     *      'actor': array{
     *          'name': string,
     *          'picture': string
     *      },
     *      'movie': array{
     *          'title': string,
     *          'picture': string
     *      },
     *  }
     */
    public function getNewQuestion(): ?array
    {
        $question = $this->gameRepository->findNextGameQuestion();

        if (null === $question) {
            return null;
        }

        return [
            'hash' => $question->getHash(),
            'actor' => [
                'name' => $question->getActorName(),
                'picture' => $question->getActorPicture(),
            ],
            'movie' => [
                'title' => $question->getMovieTitle(),
                'picture' => $question->getMoviePicture(),
            ],
        ];
    }

    /**
     * Check answer validity and get the result.
     */
    public function getResultAnswer(string $hash, ?string $playerAnswer): Result
    {
        if (!$playerAnswer) {
            throw new GameAnswerParamRequiredException();
        }

        try {
            $reply = Reply::from($playerAnswer);
        } catch (\ValueError $e) {
            throw new GameAnswerValueInvalid();
        }

        try {
            // Get the answer
            $gameAnswer = $this->gameRepository->findGameAnswerValueByHash($hash);
        } catch (\DomainException $e) {
            throw new GameAnswerHashNotFoundException($hash);
        }

        // Set question as replied
        $this->gameRepository->setGameQuestionAnsweredByHash($hash);

        return $reply->getResult($gameAnswer);
    }
}
