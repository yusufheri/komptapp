<?php

namespace App\Repository;

use App\Entity\CategoriePaiement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoriePaiement|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoriePaiement|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoriePaiement[]    findAll()
 * @method CategoriePaiement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriePaiementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoriePaiement::class);
    }

    // /**
    //  * @return CategoriePaiement[] Returns an array of CategoriePaiement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategoriePaiement
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
