<?php

namespace App\Repository;

use App\Entity\DetailImport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetailImport|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailImport|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailImport[]    findAll()
 * @method DetailImport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailImportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailImport::class);
    }

    // /**
    //  * @return DetailImport[] Returns an array of DetailImport objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DetailImport
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
