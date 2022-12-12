<?php

namespace App\Repository;

use App\Entity\RelayPointDB;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RelayPointDB|null find($id, $lockMode = null, $lockVersion = null)
 * @method RelayPointDB|null findOneBy(array $criteria, array $orderBy = null)
 * @method RelayPointDB[]    findAll()
 * @method RelayPointDB[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelayPointDBRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RelayPointDB::class);
    }

    // /**
    //  * @return RelayPointDB[] Returns an array of RelayPointDB objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function deleteAll()
    {
        $this->createQueryBuilder('r')
            ->delete()
            ->getQuery()
            ->execute();
    }

    /*
    public function findOneBySomeField($value): ?RelayPointDB
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
