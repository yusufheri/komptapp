<?php

namespace App\Repository;

use App\Entity\RubriqueCompte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RubriqueCompte|null find($id, $lockMode = null, $lockVersion = null)
 * @method RubriqueCompte|null findOneBy(array $criteria, array $orderBy = null)
 * @method RubriqueCompte[]    findAll()
 * @method RubriqueCompte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RubriqueCompteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RubriqueCompte::class);
    }

    // /**
    //  * @return RubriqueCompte[] Returns an array of RubriqueCompte objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RubriqueCompte
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
