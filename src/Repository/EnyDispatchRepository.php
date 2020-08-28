<?php

namespace App\Repository;

use App\Entity\EnyDispatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnyDispatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnyDispatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnyDispatch[]    findAll()
 * @method EnyDispatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnyDispatchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnyDispatch::class);
    }

    // /**
    //  * @return EnyDispatch[] Returns an array of EnyDispatch objects
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
    public function findOneBySomeField($value): ?EnyDispatch
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
