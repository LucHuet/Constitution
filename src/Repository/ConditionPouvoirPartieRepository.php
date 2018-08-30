<?php

namespace App\Repository;

use App\Entity\ConditionPouvoirPartie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ConditionPouvoirPartie|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConditionPouvoirPartie|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConditionPouvoirPartie[]    findAll()
 * @method ConditionPouvoirPartie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConditionPouvoirPartieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ConditionPouvoirPartie::class);
    }

//    /**
//     * @return ConditionPouvoirPartie[] Returns an array of ConditionPouvoirPartie objects
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
    public function findOneBySomeField($value): ?ConditionPouvoirPartie
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
