<?php

namespace App\Repository;

use App\Entity\EnyProvince;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnyProvince|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnyProvince|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnyProvince[]    findAll()
 * @method EnyProvince[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnyProvinceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnyProvince::class);
    }

    // /**
    //  * @return EnyProvince[] Returns an array of EnyProvince objects
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
    public function findOneBySomeField($value): ?EnyProvince
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
