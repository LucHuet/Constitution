<?php

namespace App\Repository;

use App\Entity\ConditionDesignationPartie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ConditionDesignationPartie|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConditionDesignationPartie|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConditionDesignationPartie[]    findAll()
 * @method ConditionDesignationPartie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConditionDesignationPartieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ConditionDesignationPartie::class);
    }

//    /**
//     * @return ConditionDesignationPartie[] Returns an array of ConditionDesignationPartie objects
//     */
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
    public function findOneBySomeField($value): ?ConditionDesignationPartie
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
