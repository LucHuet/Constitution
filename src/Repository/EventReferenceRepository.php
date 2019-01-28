<?php

namespace App\Repository;

use App\Entity\EventReference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EventReference|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventReference|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventReference[]    findAll()
 * @method EventReference[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventReferenceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EventReference::class);
    }

    // /**
    //  * @return EventReference[] Returns an array of EventReference objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EventReference
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
