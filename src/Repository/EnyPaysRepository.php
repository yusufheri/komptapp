<?php

namespace App\Repository;

use App\Entity\EnyPays;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnyPays|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnyPays|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnyPays[]    findAll()
 * @method EnyPays[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnyPaysRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnyPays::class);
    }

    // /**
    //  * @return EnyPays[] Returns an array of EnyPays objects
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
    public function findOneBySomeField($value): ?EnyPays
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
