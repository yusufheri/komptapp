<?php

namespace App\Repository;

use App\Entity\BankingInformation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BankingInformation|null find($id, $lockMode = null, $lockVersion = null)
 * @method BankingInformation|null findOneBy(array $criteria, array $orderBy = null)
 * @method BankingInformation[]    findAll()
 * @method BankingInformation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BankingInformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BankingInformation::class);
    }

    // /**
    //  * @return BankingInformation[] Returns an array of BankingInformation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BankingInformation
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
