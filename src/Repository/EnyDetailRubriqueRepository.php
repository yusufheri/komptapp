<?php

namespace App\Repository;

use App\Entity\EnyDetailRubrique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnyDetailRubrique|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnyDetailRubrique|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnyDetailRubrique[]    findAll()
 * @method EnyDetailRubrique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnyDetailRubriqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnyDetailRubrique::class);
    }

    // /**
    //  * @return EnyDetailRubrique[] Returns an array of EnyDetailRubrique objects
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
    public function findOneBySomeField($value): ?EnyDetailRubrique
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
