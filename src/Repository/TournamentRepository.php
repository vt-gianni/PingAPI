<?php

namespace App\Repository;

use App\Entity\Tournament;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tournament>
 *
 * @method Tournament|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tournament|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tournament[]    findAll()
 * @method Tournament[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TournamentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tournament::class);
    }

    /**
     * Récupère les tournois à venir.
     *
     * @return Tournament[]
     */
    public function findUpcomingTournaments(): array
    {
        $currentDate = new \DateTime();

        return $this->createQueryBuilder('t')
            ->where('t.beginDate >= :currentDate')
            ->setParameter('currentDate', $currentDate->setTime(0, 0, 0))
            ->orderBy('t.beginDate', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère les tournois déjà passés.
     *
     * @return Tournament[]
     */
    public function findPastTournaments(): array
    {
        $currentDate = new \DateTime();

        return $this->createQueryBuilder('t')
            ->where('t.endDate < :currentDate')
            ->setParameter('currentDate', $currentDate->setTime(0, 0, 0)) // Set the time to 00:00:00
            ->orderBy('t.endDate', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
