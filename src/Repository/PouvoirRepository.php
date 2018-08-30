<?php

namespace App\Repository;

use App\Entity\Pouvoir;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Pouvoir|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pouvoir|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pouvoir[]    findAll()
 * @method Pouvoir[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PouvoirRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Pouvoir::class);
    }

//    /**
//     * @return Pouvoir[] Returns an array of Pouvoir objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pouvoir
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
