<?php

namespace App\Repository;

use App\Entity\EnySousRubrique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnySousRubrique|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnySousRubrique|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnySousRubrique[]    findAll()
 * @method EnySousRubrique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnySousRubriqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnySousRubrique::class);
    }

    // /**
    //  * @return EnySousRubrique[] Returns an array of EnySousRubrique objects
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
    public function findOneBySomeField($value): ?EnySousRubrique
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
