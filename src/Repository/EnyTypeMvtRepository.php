<?php

namespace App\Repository;

use App\Entity\EnyTypeMvt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnyTypeMvt|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnyTypeMvt|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnyTypeMvt[]    findAll()
 * @method EnyTypeMvt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnyTypeMvtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnyTypeMvt::class);
    }

    // /**
    //  * @return EnyTypeMvt[] Returns an array of EnyTypeMvt objects
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
    public function findOneBySomeField($value): ?EnyTypeMvt
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
