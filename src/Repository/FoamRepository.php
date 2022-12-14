<?php

namespace App\Repository;

use App\Entity\Foam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Foam|null find($id, $lockMode = null, $lockVersion = null)
 * @method Foam|null findOneBy(array $criteria, array $orderBy = null)
 * @method Foam[]    findAll()
 * @method Foam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FoamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Foam::class);
    }

    // /**
    //  * @return Foam[] Returns an array of Foam objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Foam
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
