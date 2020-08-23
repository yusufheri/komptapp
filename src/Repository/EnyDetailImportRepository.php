<?php

namespace App\Repository;

use App\Entity\EnyDetailImport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnyDetailImport|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnyDetailImport|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnyDetailImport[]    findAll()
 * @method EnyDetailImport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnyDetailImportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnyDetailImport::class);
    }

    // /**
    //  * @return EnyDetailImport[] Returns an array of EnyDetailImport objects
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
    public function findOneBySomeField($value): ?EnyDetailImport
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
