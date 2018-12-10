<?php

namespace App\Repository;

use App\Entity\CountryDescription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CountryDescription|null find($id, $lockMode = null, $lockVersion = null)
 * @method CountryDescription|null findOneBy(array $criteria, array $orderBy = null)
 * @method CountryDescription[]    findAll()
 * @method CountryDescription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CountryDescriptionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CountryDescription::class);
    }

    // /**
    //  * @return CountryDescription[] Returns an array of CountryDescription objects
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
    public function findOneBySomeField($value): ?CountryDescription
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
