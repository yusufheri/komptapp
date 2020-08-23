<?php

namespace App\Repository;

use App\Entity\EnyInscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnyInscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnyInscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnyInscription[]    findAll()
 * @method EnyInscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnyInscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnyInscription::class);
    }

    // /**
    //  * @return EnyInscription[] Returns an array of EnyInscription objects
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
    public function findOneBySomeField($value): ?EnyInscription
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
