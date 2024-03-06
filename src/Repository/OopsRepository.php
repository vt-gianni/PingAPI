<?php

namespace App\Repository;

use App\Entity\Oops;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Oops>
 *
 * @method Oops|null find($id, $lockMode = null, $lockVersion = null)
 * @method Oops|null findOneBy(array $criteria, array $orderBy = null)
 * @method Oops[]    findAll()
 * @method Oops[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OopsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Oops::class);
    }

//    /**
//     * @return Oops[] Returns an array of Oops objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Oops
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
