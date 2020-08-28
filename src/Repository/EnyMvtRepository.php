<?php

namespace App\Repository;

use App\Entity\EnyMvt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnyMvt|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnyMvt|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnyMvt[]    findAll()
 * @method EnyMvt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnyMvtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnyMvt::class);
    }

    // /**
    //  * @return EnyMvt[] Returns an array of EnyMvt objects
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
    public function findOneBySomeField($value): ?EnyMvt
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
