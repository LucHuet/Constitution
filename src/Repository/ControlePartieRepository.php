<?php

namespace App\Repository;

use App\Entity\ControlePartie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ControlePartie|null find($id, $lockMode = null, $lockVersion = null)
 * @method ControlePartie|null findOneBy(array $criteria, array $orderBy = null)
 * @method ControlePartie[]    findAll()
 * @method ControlePartie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ControlePartieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ControlePartie::class);
    }

    // /**
    //  * @return ControlePartie[] Returns an array of ControlePartie objects
    //  */
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
    public function findOneBySomeField($value): ?ControlePartie
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
