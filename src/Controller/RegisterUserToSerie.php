<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;

class RegisterUserToSerie extends AbstractController
{
    function __construct(
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository,
        private SerieRepository $serieRepository
    )
    {
        
    }

    public function __invoke(int $id, int $userId)
    {
        $serie = $this->serieRepository->find($id);
        $user = $this->userRepository->find($userId);
        if (!$serie) {
            throw $this->createNotFoundException("La série n'existe pas.");
        }
        if (!$user) {
            throw $this->createNotFoundException("L'utilisateur n'existe pas.");
        }
        if ($serie->getUsersRegistered()->contains($user)) {
            throw $this->createNotFoundException("L'utilisateur est déjà inscrit à cette série.");
        }
        $serie->addUsersRegistered($user);
        $this->entityManager->flush();
        return $this->json($serie, 201);
    }
}