<?php

namespace App\Repository;

use App\Entity\EnyImport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnyImport|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnyImport|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnyImport[]    findAll()
 * @method EnyImport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnyImportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnyImport::class);
    }

    // /**
    //  * @return EnyImport[] Returns an array of EnyImport objects
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
    public function findOneBySomeField($value): ?EnyImport
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
