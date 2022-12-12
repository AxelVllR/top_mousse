<?php

namespace App\Repository;

use App\Entity\WrapItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WrapItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method WrapItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method WrapItem[]    findAll()
 * @method WrapItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WrapItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WrapItem::class);
    }

    // /**
    //  * @return WrapItem[] Returns an array of WrapItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WrapItem
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
