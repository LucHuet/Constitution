<?php

namespace App\Repository;

use App\Entity\ValeurPrincipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ValeurPrincipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method ValeurPrincipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method ValeurPrincipe[]    findAll()
 * @method ValeurPrincipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValeurPrincipeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ValeurPrincipe::class);
    }

//    /**
//     * @return ValeurPrincipe[] Returns an array of ValeurPrincipe objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ValeurPrincipe
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
