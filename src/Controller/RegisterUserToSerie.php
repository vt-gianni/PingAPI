<?php

namespace App\Controller;

use App\Entity\Serie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RegisterUserToSerie extends AbstractController
{
    function __construct(private readonly EntityManagerInterface $entityManager,
                         private readonly RequestStack $requestStack,
                         private readonly UserRepository $userRepository)
    {}

    public function __invoke(Serie $serie): JsonResponse
    {
        $data = json_decode($this->requestStack->getCurrentRequest()->getContent(), true);

        if (!array_key_exists('userId', $data)) {
            throw new BadRequestHttpException('Le champ "userId" manque.');
        }

        if (!($user = $this->userRepository->find($data['userId']))) {
            throw new NotFoundHttpException('L\'utilisateur n\'existe pas.');
        }

        if ($serie->getUsersRegistered()->contains($user)) {
            throw $this->createNotFoundException("L'utilisateur est déjà inscrit à cette série.");
        }
        $serie->addUsersRegistered($user);
        $this->entityManager->flush();
        return $this->json($serie, 201);
    }
}
