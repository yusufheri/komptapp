<?php

namespace App\Repository;

use App\Entity\EnyBank;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnyBank|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnyBank|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnyBank[]    findAll()
 * @method EnyBank[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnyBankRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnyBank::class);
    }

    // /**
    //  * @return EnyBank[] Returns an array of EnyBank objects
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
    public function findOneBySomeField($value): ?EnyBank
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
