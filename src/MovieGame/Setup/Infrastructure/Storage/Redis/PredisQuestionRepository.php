<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Setup\Infrastructure\Storage\Redis;

use App\MovieGame\Setup\Domain\Question\Question;
use App\MovieGame\Setup\Domain\Question\QuestionRepositoryInterface;

/**
 * PredisQuestionRepository class that implement QuestionRepositoryInterface.
 */
class PredisQuestionRepository implements QuestionRepositoryInterface
{
    public const PREFIX_QUESTION = 'question:';
    public const PREFIX_MAP = 'map:';

    public function __construct(
        private \Predis\Client $client,
    ) {
    }

    public function store(Question $question): void
    {
        // Get the next index to insert question into cache
        $index_setup = $this->client->get(self::PREFIX_MAP.'index_setup') ?: 0;

        // Store question by its hash
        $this->client->set(self::PREFIX_QUESTION.$question->getHash(), serialize($question));

        // Store correspondance hash <> index
        $this->client->set(self::PREFIX_MAP.$index_setup, $question->getHash());

        // Set the next index to insert question into cache
        $this->client->incr(self::PREFIX_MAP.'index_setup');
    }

    /**
     * Save many questions into database.
     *
     * @param Question[] $questions
     */
    public function storeMany(array $questions): void
    {
        array_map(
            fn ($question) => $this->store($question),
            $questions
        );
    }
}
