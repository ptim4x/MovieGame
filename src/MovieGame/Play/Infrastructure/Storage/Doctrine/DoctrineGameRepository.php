<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\MovieGame\Play\Infrastructure\Storage\Doctrine;

use App\Entity\Answer;
use App\Entity\Question;
use App\MovieGame\Play\Domain\Game\Game;
use App\MovieGame\Play\Domain\Game\GameRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * TheMovieDbApi class that implement MovieApiInterface.
 */
class DoctrineGameRepository implements GameRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
    }

    /**
     * Find next game question.
     */
    public function findNextGameQuestion(): ?Game
    {
        return $this->em->createQueryBuilder()
            // Question DB data forwarded into Game DTO, with help of NEW Doctrine operator
            ->select(sprintf(
                'NEW %s(
                    actor.name,
                    actor.picture,
                    movie.title,
                    movie.picture,
                    answer.hash
                )',
                Game::class
            ))
            ->from(Question::class, 'question')
            ->innerJoin('question.actor', 'actor')
            ->innerJoin('question.movie', 'movie')
            ->innerJoin('question.answer', 'answer')
            ->andWhere('answer.answeredAt is NULL')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * Find by hash the game answer value.
     *
     * @throws \DomainException
     */
    public function findGameAnswerValueByHash(string $hash): bool
    {
        return $this->findGameAnswerByHash($hash)->isValue();
    }

    /**
     * Set by hash the game question answered.
     *
     * @throws \DomainException
     */
    public function setGameQuestionAnsweredByHash(string $hash): void
    {
        $answer = $this->findGameAnswerByHash($hash);

        // Store date time of the answer
        $answer->setAnsweredAt(new \DateTimeImmutable());
        $this->em->persist($answer);
        $this->em->flush();
    }

    /**
     * Find by hash the game answer.
     *
     * @throws \DomainException
     */
    private function findGameAnswerByHash(string $hash): Answer
    {
        /** @var ?Answer $answer */
        $answer = $this->em->getRepository(Answer::class)->findOneBy(['hash' => $hash]);

        if (!$answer) {
            throw new \DomainException('Answer not found');
        }

        return $answer;
    }
}
