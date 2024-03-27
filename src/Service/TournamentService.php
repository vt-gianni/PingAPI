<?php

namespace App\Service;

use App\Entity\Serie;
use App\Entity\Tournament;
use App\Entity\User;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TournamentService
{
    public function __construct(private readonly EntityManagerInterface $entityManager,
                                private readonly Security               $security,
                                private readonly SerieRepository        $serieRepository)
    {}

    /**
     * @param Tournament $tournament
     * @param array $series
     * @return void
     */
    public function register(Tournament $tournament, array $series): void
    {
        /** @var User $currentUser */
        $currentUser = $this->security->getUser();

        foreach ($series as $serieId) {
            if (!($serie = $this->serieRepository->find($serieId))) {
                throw new BadRequestHttpException('Cette série n\'existe pas.');
            }
            $this->checkRegistrationConditions($tournament, $serie, $currentUser);
            $serie->addUsersRegistered($currentUser);
        }

        $this->entityManager->flush();
    }

    /**
     * @param Tournament $tournament
     * @param Serie $serie
     * @param User $user
     * @return void
     */
    private function checkRegistrationConditions(Tournament $tournament, Serie $serie, User $user): void
    {
        if ($serie->getTournament() !== $tournament) {
            throw new BadRequestHttpException('Cette série ne correspond pas au tournoi sélectionné.');
        }
        if ($serie->getUsersRegistered()->contains($user)) {
            throw new BadRequestHttpException('Vous êtes déjà inscrit à cette série.');
        }
        if (!$serie->isCanRegister()) {
            throw new BadRequestHttpException('Cette série n\'accepte plus les inscriptions.');
        }
        if ($serie->getUsersRegistered()->count() >= $serie->getMaxPlaces()) {
            throw new BadRequestHttpException('Cette série est complète.');
        }
    }
}
