<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\TournamentRepository;

class TournamentProvider implements ProviderInterface
{
    public function __construct(private readonly TournamentRepository $repository)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        return [
            'upcoming' => $this->repository->findUpcomingTournaments(),
            'inprogress' => $this->repository->findInProgressTournaments(),
            'past' => $this->repository->findPastTournaments(),
        ];
    }

}
