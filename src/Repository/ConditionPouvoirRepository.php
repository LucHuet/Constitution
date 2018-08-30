<?php

namespace App\Repository;

use App\Entity\ConditionPouvoir;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ConditionPouvoir|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConditionPouvoir|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConditionPouvoir[]    findAll()
 * @method ConditionPouvoir[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConditionPouvoirRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ConditionPouvoir::class);
    }

//    /**
//     * @return ConditionPouvoir[] Returns an array of ConditionPouvoir objects
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
    public function findOneBySomeField($value): ?ConditionPouvoir
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
