<?php

namespace App\Repository;

use App\Entity\EnyTranche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnyTranche|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnyTranche|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnyTranche[]    findAll()
 * @method EnyTranche[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnyTrancheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnyTranche::class);
    }

    // /**
    //  * @return EnyTranche[] Returns an array of EnyTranche objects
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
    public function findOneBySomeField($value): ?EnyTranche
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
