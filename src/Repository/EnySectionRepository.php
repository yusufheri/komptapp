<?php

namespace App\Repository;

use App\Entity\EnySection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnySection|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnySection|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnySection[]    findAll()
 * @method EnySection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnySectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnySection::class);
    }

    // /**
    //  * @return EnySection[] Returns an array of EnySection objects
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
    public function findOneBySomeField($value): ?EnySection
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
