<?php

namespace App\Repository;

use App\Entity\SerieUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SerieUser>
 *
 * @method SerieUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method SerieUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method SerieUser[]    findAll()
 * @method SerieUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerieUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SerieUser::class);
    }

//    /**
//     * @return SerieUser[] Returns an array of SerieUser objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SerieUser
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
