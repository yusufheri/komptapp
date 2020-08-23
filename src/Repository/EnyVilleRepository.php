<?php

namespace App\Repository;

use App\Entity\EnyVille;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnyVille|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnyVille|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnyVille[]    findAll()
 * @method EnyVille[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnyVilleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnyVille::class);
    }

    // /**
    //  * @return EnyVille[] Returns an array of EnyVille objects
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
    public function findOneBySomeField($value): ?EnyVille
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
