<?php

namespace App\Repository;

use App\Entity\EnyDepartement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnyDepartement|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnyDepartement|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnyDepartement[]    findAll()
 * @method EnyDepartement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnyDepartementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnyDepartement::class);
    }

    // /**
    //  * @return EnyDepartement[] Returns an array of EnyDepartement objects
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
    public function findOneBySomeField($value): ?EnyDepartement
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
