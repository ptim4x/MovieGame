<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Setup\Infrastructure\Storage\Doctrine;

use App\Entity\Actor as EntityActor;
use App\Entity\Answer as EntityAnswer;
use App\Entity\Movie as EntityMovie;
use App\Entity\Question as EntityQuestion;
use App\MovieGame\Setup\Domain\Question\Question;
use App\MovieGame\Setup\Domain\Question\QuestionRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * TheMovieDbApi class that implement MovieApiInterface.
 */
class DoctrineQuestionRepository implements QuestionRepositoryInterface
{
    public function __construct(
        private ManagerRegistry $doctrine,
    ) {
    }

    /**
     * Save a question into database.
     */
    public function store(Question $question, bool $withFlush = true): void
    {
        $entityQuestion = $this->createEntities($question);

        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($entityQuestion);
        $entityManager->flush();
    }

    /**
     * Save many questions into database.
     *
     * @param Question[] $questions
     */
    public function storeMany(array $questions): void
    {
        $entityManager = $this->doctrine->getManager();

        array_map(
            function ($question) use ($entityManager): void {
                $entityQuestion = $this->createEntities($question);
                $entityManager->persist($entityQuestion);
            },
            $questions
        );

        $entityManager->flush();
    }

    /**
     * Create a new entity Question.
     */
    private function createEntities(Question $question): EntityQuestion
    {
        $actorRepository = $this->doctrine->getRepository(EntityActor::class);

        $actorId = $question->getActor()->getExternalId();
        $actor = $actorRepository->findOneBy(['external_id' => $actorId]);
        if (empty($actor)) {
            $actor = (new EntityActor())
                ->setExternalId($question->getActor()->getExternalId())
                ->setName($question->getActor()->getName())
                ->setPicture($question->getActor()->getPicture())
            ;
        }

        $movie = (new EntityMovie())
            ->setExternalId($question->getMovie()->getExternalId())
            ->setTitle($question->getMovie()->getTitle())
            ->setPicture($question->getMovie()->getPicture())
        ;

        $answer = (new EntityAnswer())->setHash($question->getHash())
            ->setValue($question->getAnswer())
        ;

        return (new EntityQuestion())->setActor($actor)
            ->setMovie($movie)
            ->setAnswer($answer)
        ;
    }
}
