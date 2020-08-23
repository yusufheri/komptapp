<?php

namespace App\Repository;

use App\Entity\EnyRubriqueCpt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnyRubriqueCpt|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnyRubriqueCpt|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnyRubriqueCpt[]    findAll()
 * @method EnyRubriqueCpt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnyRubriqueCptRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnyRubriqueCpt::class);
    }

    // /**
    //  * @return EnyRubriqueCpt[] Returns an array of EnyRubriqueCpt objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EnyRubriqueCpt
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
