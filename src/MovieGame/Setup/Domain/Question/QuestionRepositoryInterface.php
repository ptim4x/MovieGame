<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Setup\Domain\Question;

interface QuestionRepositoryInterface
{
    /**
     * Store a question.
     */
    public function store(Question $question): void;

    /**
     * Store many questions.
     *
     * @param Question[] $questions
     */
    public function storeMany(array $questions): void;

    /**
     * Remove a question from database.
     */
    public function remove(Question $question): void;

    /**
     * Is the question exists ?
     */
    public function exists(Question $question): bool;
}
