<?php

namespace App\Repository;

use App\Entity\DetailRubrique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetailRubrique|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailRubrique|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailRubrique[]    findAll()
 * @method DetailRubrique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailRubriqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailRubrique::class);
    }

    // /**
    //  * @return DetailRubrique[] Returns an array of DetailRubrique objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DetailRubrique
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
