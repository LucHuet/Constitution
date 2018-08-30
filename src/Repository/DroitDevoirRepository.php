<?php

namespace App\Repository;

use App\Entity\DroitDevoir;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DroitDevoir|null find($id, $lockMode = null, $lockVersion = null)
 * @method DroitDevoir|null findOneBy(array $criteria, array $orderBy = null)
 * @method DroitDevoir[]    findAll()
 * @method DroitDevoir[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DroitDevoirRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DroitDevoir::class);
    }

//    /**
//     * @return DroitDevoir[] Returns an array of DroitDevoir objects
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
    public function findOneBySomeField($value): ?DroitDevoir
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
