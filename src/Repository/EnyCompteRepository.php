<?php

namespace App\Repository;

use App\Entity\EnyCompte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnyCompte|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnyCompte|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnyCompte[]    findAll()
 * @method EnyCompte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnyCompteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnyCompte::class);
    }

    // /**
    //  * @return EnyCompte[] Returns an array of EnyCompte objects
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
    public function findOneBySomeField($value): ?EnyCompte
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
