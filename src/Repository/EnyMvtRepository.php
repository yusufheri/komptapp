<?php

namespace App\Repository;

use App\Entity\EnyMvt;
use App\Entity\EnyTypeMvt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnyMvt|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnyMvt|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnyMvt[]    findAll()
 * @method EnyMvt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnyMvtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnyMvt::class);
    }
    

    public function success(EnyTypeMvt $typeMvt): array
    {
        $q = $this->createQueryBuilder('e');
        return      $q
                    ->select('d', 'e')
                    ->join('e.devise', 'd')                   
                    ->addSelect('r', 'e')
                    ->join('e.rubrique', 'r')
                    ->addSelect('i', 'e')
                    ->join('e.student', 'i')
                    //->addSelect('s', 'i')
                    //->join('i.num_eny_etudiant', 's')
                    ->andWhere('e.typeMvt = :val')
                    ->setParameter('val', $typeMvt)
                    ->andWhere('e.success = :val2')
                    ->setParameter('val2', true)
                    ->andWhere('e.dispatch = :val3')
                    ->setParameter('val3', true)
                    ->orderBy('e.createdAt', 'DESC')
                    ->getQuery()
                    ->getResult()
                    ;
    }

    public function corriger(EnyTypeMvt $typeMvt): array
    {
        
        $q = $this->createQueryBuilder('e');
        return      $q
                    ->select('d', 'e')
                    ->join('e.devise', 'd') 
                    ->andWhere('e.typeMvt = :val')
                    ->setParameter('val', $typeMvt)
                    ->andWhere('e.error = :val2')
                    ->setParameter('val2', true)
                    ->andWhere($q->expr()->isNull('e.success'))
                    ->orderBy('e.createdAt', 'DESC')
                    ->getQuery()
                    ->getResult()
                    ;
    }

    public function dispatch(EnyTypeMvt $typeMvt): array
    {
        $q = $this->createQueryBuilder('e');
        return      $q
                    ->select('d', 'e')
                    ->join('e.devise', 'd')                   
                    ->addSelect('r', 'e')
                    ->join('e.rubrique', 'r')
                    ->addSelect('i', 'e')
                    ->join('e.student', 'i')
                    //->addSelect('s', 'i')
                    //->join('i.num_eny_etudiant', 's')
                    ->andWhere('e.typeMvt = :val')
                    ->setParameter('val', $typeMvt)
                    ->andWhere('e.success = :val2')
                    ->setParameter('val2', true)
                    ->andWhere($q->expr()->isNull('e.dispatch'))
                    ->andWhere($q->expr()->isNull('e.error'))
                    ->orderBy('e.createdAt', 'DESC')
                    ->getQuery()
                    ->getResult()
                    ;
    }

    /**
     * Permet de retourner toutes les entrées enregistrées
     *
     * @return EnyMvt[] Returns an array of EnyMvt objects
     */
    public function findMvt(EnyTypeMvt $typeMvt): array
    {
        
        return $this->createQueryBuilder('e')
                    ->select('d', 'e')
                    ->join('e.devise', 'd')                   
                    //->addSelect('r', 'e')
                    //->join('e.rubrique', 'r')
                    //->addSelect('i', 'e')
                    //->join('e.student', 'i')
                    //->addSelect('s', 'i')
                    //->join('i.num_eny_etudiant', 's')
                    ->andWhere('e.typeMvt = :val')
                    ->setParameter('val', $typeMvt)
                    ->orderBy('e.createdAt', 'DESC')
                    ->getQuery()
                    ->getResult()
                    ;
    }

    // /**
    //  * @return EnyMvt[] Returns an array of EnyMvt objects
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
    public function findOneBySomeField($value): ?EnyMvt
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
