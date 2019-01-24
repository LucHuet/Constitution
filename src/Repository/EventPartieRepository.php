<?php

namespace App\Repository;

use App\Entity\EventPartie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EventPartie|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventPartie|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventPartie[]    findAll()
 * @method EventPartie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventPartieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EventPartie::class);
    }

    // /**
    //  * @return EventPartie[] Returns an array of EventPartie objects
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
    public function findOneBySomeField($value): ?EventPartie
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
