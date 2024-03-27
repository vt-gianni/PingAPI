<?php

namespace App\Repository;

use App\Entity\Tournament;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
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
     * @param QueryBuilder $qb
     * @param User $user
     * @param bool $mine
     * @return QueryBuilder
     */
    private function getMine(QueryBuilder $qb, User $user, bool $mine): QueryBuilder
    {
        if ($mine) {
            $qb->join('t.series', 's')->join('s.usersRegistered', 'u');
            $qb->andWhere('u.id = :userId')->setParameter('userId', $user->getId());
        }
        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param string|null $search
     * @return QueryBuilder
     */
    private function search(QueryBuilder $qb, ?string $search): QueryBuilder
    {
        if ($search) {
            $qb->andWhere('LOWER(t.city) LIKE :city')->setParameter('city',  strtolower($search) . '%');
        }
        return $qb;
    }

    /**
     * Récupère les tournois à venir.
     *
     * @return Tournament[]
     */
    public function findUpcomingTournaments(User $user, bool $mine = false, ?string $search = null): array
    {
        $currentDate = new \DateTime();

        $qb = $this->createQueryBuilder('t')
            ->where('t.beginDate >= :currentDate')
            ->setParameter('currentDate', $currentDate->setTime(0, 0, 0));

        $qb = $this->getMine($qb, $user, $mine);
        $qb = $this->search($qb, $search);

        return $qb
            ->orderBy('t.beginDate', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Récupère les tournois déjà passés.
     *
     * @return Tournament[]
     */
    public function findPastTournaments(User $user, bool $mine = false, ?string $search = null): array
    {
        $currentDate = new \DateTime();

        $qb = $this->createQueryBuilder('t')
            ->where('t.endDate < :currentDate')
            ->setParameter('currentDate', $currentDate->setTime(0, 0, 0));

        $qb = $this->getMine($qb, $user, $mine);
        $qb = $this->search($qb, $search);

        return $qb
            ->orderBy('t.endDate', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Récupère les tournois en cours.
     *
     * @return Tournament[]
     */
    public function findInProgressTournaments(User $user, bool $mine = false, ?string $search = null): array
    {
        $currentDate = new \DateTime();

        $qb = $this->createQueryBuilder('t')
            ->where('t.beginDate <= :beginDate')
            ->setParameter('beginDate', $currentDate->setTime(0, 0, 0))
            ->andWhere('t.endDate >= :endDate')
            ->setParameter('endDate', $currentDate->setTime(0, 0, 0));

        $qb = $this->getMine($qb, $user, $mine);
        $qb = $this->search($qb, $search);

        return $qb
            ->orderBy('t.endDate', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
