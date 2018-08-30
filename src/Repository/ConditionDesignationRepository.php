<?php

namespace App\Repository;

use App\Entity\ConditionDesignation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ConditionDesignation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConditionDesignation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConditionDesignation[]    findAll()
 * @method ConditionDesignation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConditionDesignationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ConditionDesignation::class);
    }

//    /**
//     * @return ConditionDesignation[] Returns an array of ConditionDesignation objects
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
    public function findOneBySomeField($value): ?ConditionDesignation
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
