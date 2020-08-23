<?php

namespace App\Repository;

use App\Entity\EnyFaculte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnyFaculte|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnyFaculte|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnyFaculte[]    findAll()
 * @method EnyFaculte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnyFaculteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnyFaculte::class);
    }

    // /**
    //  * @return EnyFaculte[] Returns an array of EnyFaculte objects
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
    public function findOneBySomeField($value): ?EnyFaculte
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
