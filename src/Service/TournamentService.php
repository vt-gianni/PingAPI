<?php

namespace App\Service;

use App\Entity\Serie;
use App\Entity\SerieUser;
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

        foreach ($series as $serieElement) {
            if (!array_key_exists('id', $serieElement) || !array_key_exists('hasPaid', $serieElement)) {
                throw new BadRequestHttpException('Les champs id et hasPaid sont obligatoires dans chaque série renseignée.');
            }
            if (!($serie = $this->serieRepository->find($serieElement['id']))) {
                throw new BadRequestHttpException('Cette série n\'existe pas.');
            }
            $this->checkRegistrationConditions($tournament, $serie, $currentUser);
            $serieUser = new SerieUser();
            $serieUser->setSerie($serie);
            $serieUser->setUser($currentUser);
            $serieUser->setHasPaid(boolval($serieElement['hasPaid']));
            $this->entityManager->persist($serieUser);

            $serie->addSerieUser($serieUser);
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
        foreach ($serie->getSerieUsers() as $serieUser) {
            if ($serieUser->getUser() === $user) {
                throw new BadRequestHttpException('Vous êtes déjà inscrit à cette série.');
            }
        }
        if (!$serie->isCanRegister()) {
            throw new BadRequestHttpException('Cette série n\'accepte plus les inscriptions.');
        }
        if ($serie->getSerieUsers()->count() >= $serie->getMaxPlaces()) {
            throw new BadRequestHttpException('Cette série est complète.');
        }
    }
}
