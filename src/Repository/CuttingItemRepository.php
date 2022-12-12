<?php

namespace App\Repository;

use App\Entity\CuttingItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CuttingItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method CuttingItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method CuttingItem[]    findAll()
 * @method CuttingItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CuttingItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CuttingItem::class);
    }

    // /**
    //  * @return CuttingItem[] Returns an array of CuttingItem objects
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
    public function findOneBySomeField($value): ?CuttingItem
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
