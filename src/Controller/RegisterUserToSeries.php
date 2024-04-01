<?php

namespace App\Controller;

use App\Entity\Tournament;
use App\Service\TournamentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RegisterUserToSeries extends AbstractController
{
    function __construct(private readonly TournamentService $tournamentService,
                         private readonly RequestStack $requestStack)
    {}

    public function __invoke(Tournament $tournament): JsonResponse
    {
        $data = json_decode($this->requestStack->getCurrentRequest()->getContent(), true);

        if (!array_key_exists('userSeries', $data) || !is_array($data['userSeries'])) {
            throw new BadRequestHttpException('Le champ "userSeries" manque.');
        }

        $this->tournamentService->register($tournament, $data['userSeries']);

        return $this->json($tournament, 201);
    }
}
