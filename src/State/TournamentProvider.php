<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\User;
use App\Repository\TournamentRepository;
use Symfony\Bundle\SecurityBundle\Security;

class TournamentProvider implements ProviderInterface
{
    public function __construct(private readonly TournamentRepository $repository, private readonly Security $security)
    {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $mine = false;
        if (array_key_exists('filters', $context) && array_key_exists('mine', $context['filters'])) {
            $mine = boolval($context['filters']);
        }
        /** @var User $user */
        $user = $this->security->getUser();

        return [
            'upcoming' => $this->repository->findUpcomingTournaments($user, $mine),
            'inprogress' => $this->repository->findInProgressTournaments($user, $mine),
            'past' => $this->repository->findPastTournaments($user, $mine),
        ];
    }

}
