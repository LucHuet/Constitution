<?php

namespace App\Repository;

use App\Entity\DesignationPartie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DesignationPartie|null find($id, $lockMode = null, $lockVersion = null)
 * @method DesignationPartie|null findOneBy(array $criteria, array $orderBy = null)
 * @method DesignationPartie[]    findAll()
 * @method DesignationPartie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DesignationPartieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DesignationPartie::class);
    }

//    /**
//     * @return DesignationPartie[] Returns an array of DesignationPartie objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DesignationPartie
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
