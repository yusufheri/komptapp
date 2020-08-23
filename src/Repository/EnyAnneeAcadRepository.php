<?php

namespace App\Repository;

use App\Entity\EnyAnneeAcad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnyAnneeAcad|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnyAnneeAcad|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnyAnneeAcad[]    findAll()
 * @method EnyAnneeAcad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnyAnneeAcadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnyAnneeAcad::class);
    }

    // /**
    //  * @return EnyAnneeAcad[] Returns an array of EnyAnneeAcad objects
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
    public function findOneBySomeField($value): ?EnyAnneeAcad
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
