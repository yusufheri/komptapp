<?php

namespace App\Repository;

use App\Entity\EnyCatEtab;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnyCatEtab|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnyCatEtab|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnyCatEtab[]    findAll()
 * @method EnyCatEtab[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnyCatEtabRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnyCatEtab::class);
    }

    // /**
    //  * @return EnyCatEtab[] Returns an array of EnyCatEtab objects
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
    public function findOneBySomeField($value): ?EnyCatEtab
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
