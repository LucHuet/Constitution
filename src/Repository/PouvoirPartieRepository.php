<?php

namespace App\Repository;

use App\Entity\PouvoirPartie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PouvoirPartie|null find($id, $lockMode = null, $lockVersion = null)
 * @method PouvoirPartie|null findOneBy(array $criteria, array $orderBy = null)
 * @method PouvoirPartie[]    findAll()
 * @method PouvoirPartie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PouvoirPartieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PouvoirPartie::class);
    }

//    /**
//     * @return PouvoirPartie[] Returns an array of PouvoirPartie objects
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

    public function findByListOfPouvoirId($pouvoirId, $partieCourante)
    {
        return $this->createQueryBuilder('pp')
            ->join('pp.pouvoir', 'p')
            ->where('pp.partie = :partieCourante')
            ->andWhere("p.id IN(:pouvoirId)")
            ->setParameter('pouvoirId', array_values($pouvoirId))
            ->setParameter('partieCourante', $partieCourante)
            ->getQuery()
            ->getResult()
        ;
    }

}
