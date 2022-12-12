<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Play\Infrastructure\Storage\Redis;

use App\MovieGame\Play\Domain\Game\Game;
use App\MovieGame\Play\Domain\Game\GameRepositoryInterface;
use App\MovieGame\Setup\Domain\Question\Question;

/**
 * PredisGameRepository class that implement GameRepositoryInterface.
 */
class PredisGameRepository implements GameRepositoryInterface
{
    public const PREFIX_QUESTION = 'question:';
    public const PREFIX_MAP = 'map:';

    public function __construct(
        private \Predis\Client $client,
    ) {
    }

    /**
     * Find next game question.
     */
    public function findNextGameQuestion(): ?Game
    {
        $index_setup = $this->client->get(self::PREFIX_MAP.'index_setup');
        // No question set
        if (null === $index_setup) {
            return null;
        }

        $index_play = $this->client->get(self::PREFIX_MAP.'index_play') ?: 0;
        // No more question
        if ($index_play > $index_setup) {
            return null;
        }
        // Increment index play for next request
        $this->client->incr(self::PREFIX_MAP.'index_play');

        // Get correspondance index <> hash
        $hash = $this->client->get(self::PREFIX_MAP.$index_play);
        // Hash not found
        if (null === $hash) {
            return null;
        }
        // Remove current index
        $this->client->del(self::PREFIX_MAP.$index_play);

        $question = $this->getQuestionByHash($hash);
        // Question not found
        if (null === $question) {
            return null;
        }

        return new Game(
            $index_play + 0,
            $question->getActor()->getName(),
            $question->getActor()->getPicture(),
            $question->getMovie()->getTitle(),
            $question->getMovie()->getPicture(),
            $question->getHash()
        );
    }

    /**
     * Find by hash the game answer value.
     *
     * @throws \DomainException
     */
    public function findGameAnswerValueByHash(string $hash): bool
    {
        $question = $this->getQuestionByHash($hash);

        return $question?->getAnswer() ?? false;
    }

    /**
     * Set by hash the game question answered.
     *
     * @throws \DomainException
     */
    public function setGameQuestionAnsweredByHash(string $hash): void
    {
        $this->client->del(self::PREFIX_QUESTION.$hash);
    }

    /**
     * Find by hash the question.
     *
     * @throws \DomainException
     */
    protected function getQuestionByHash(string $hash): ?Question
    {
        // Get question by its hash
        $question_string = $this->client->get(self::PREFIX_QUESTION.$hash);

        // Hash not found
        if (null === $question_string) {
            return null;
        }

        return unserialize($question_string);
    }
}
