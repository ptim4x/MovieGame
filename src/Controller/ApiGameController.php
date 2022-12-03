<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\Controller;

use App\MovieGame\Play\Domain\Game\Exception\GameAnswerHashNotFoundException;
use App\MovieGame\Play\Domain\Game\Exception\GameAnswerParamRequiredException;
use App\MovieGame\Play\Domain\Game\Exception\GameAnswerValueInvalid;
use App\MovieGame\Play\Domain\Game\GameService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiGameController extends AbstractController
{
    public function __construct(private GameService $game)
    {
    }

    #[Route('/game/play', name: 'app_api_question', methods: ['GET'])]
    public function gameQuestion(): Response
    {
        $question = $this->game->getNewQuestion();

        $payload = ['result' => $question];
        if (null === $question) {
            $payload['info'] = 'No more question';
        }

        return $this->json($payload, 200);
    }

    #[Route('/game/play/{hash}', name: 'app_api_answer', methods: ['POST'])]
    public function gameAnswer(string $hash, Request $request): Response
    {
        $playerAnswer = $request->request->get('answer');

        try {
            $result = $this->game->getResultAnswer($hash, $playerAnswer);
        } catch (GameAnswerParamRequiredException $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        } catch (GameAnswerValueInvalid $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        } catch (GameAnswerHashNotFoundException $e) {
            return $this->json(['error' => $e->getMessage()], 404);
        }

        return $this->json(['result' => $result], 200);
    }
}
