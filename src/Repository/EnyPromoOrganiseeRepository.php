<?php

namespace App\Repository;

use App\Entity\EnyPromoOrganisee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnyPromoOrganisee|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnyPromoOrganisee|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnyPromoOrganisee[]    findAll()
 * @method EnyPromoOrganisee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnyPromoOrganiseeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnyPromoOrganisee::class);
    }

    // /**
    //  * @return EnyPromoOrganisee[] Returns an array of EnyPromoOrganisee objects
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
    public function findOneBySomeField($value): ?EnyPromoOrganisee
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
