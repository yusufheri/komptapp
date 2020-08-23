<?php

namespace App\Repository;

use App\Entity\EnyRubrique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnyRubrique|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnyRubrique|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnyRubrique[]    findAll()
 * @method EnyRubrique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnyRubriqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnyRubrique::class);
    }

    // /**
    //  * @return EnyRubrique[] Returns an array of EnyRubrique objects
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
    public function findOneBySomeField($value): ?EnyRubrique
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
