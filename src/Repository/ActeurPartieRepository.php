<?php

namespace App\Repository;

use App\Entity\ActeurPartie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ActeurPartie|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActeurPartie|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActeurPartie[]    findAll()
 * @method ActeurPartie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActeurPartieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ActeurPartie::class);
    }

//    /**
//     * @return ActeurPartie[] Returns an array of ActeurPartie objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ActeurPartie
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
