<?php

namespace App\Repository;

use App\Entity\EnyEtab;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnyEtab|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnyEtab|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnyEtab[]    findAll()
 * @method EnyEtab[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnyEtabRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnyEtab::class);
    }

    // /**
    //  * @return EnyEtab[] Returns an array of EnyEtab objects
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
    public function findOneBySomeField($value): ?EnyEtab
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
