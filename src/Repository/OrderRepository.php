<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function findProduction()
    {
        return $this->createQueryBuilder('o')
            ->where('o.status > 3')
            ->getQuery()
            ->getResult();
    }

    public function findByYear($year)
    {
        return $this->createQueryBuilder('o')
            ->where('YEAR(o.createdAt) = :year')
            ->setParameter('year', $year)
            ->getQuery()
            ->getResult();
    }

    public function getOrderByOrderNumberBetweenTwoValues($orderNumber1, $orderNumber2){
        return $this->createQueryBuilder('o')
            ->where('o.orderNumber >= :orderNumber1 AND o.orderNumber <= :orderNumber2')
            ->setParameter('orderNumber1', $orderNumber1)
            ->setParameter('orderNumber2', $orderNumber2)
            ->getQuery()
            ->getResult();
    }

    public function findByPeriod($start, $end)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.createdAt BETWEEN :start AND :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->andWhere('o.status = 8')
            ->getQuery()
            ->getResult();
    }

    public function findAllLimit($limit, string $orderNumber = null)
    {
        $qb = $this->createQueryBuilder('o')
            ->setMaxResults($limit)
            ->andWhere('o.status != 1')
            ->andWhere('o.status != 8');

        if($orderNumber) {
            $qb->andWhere('o.orderNumber = :orderNumber')
                ->setParameter('orderNumber', $orderNumber);
        }

        return $qb->getQuery()->getResult();
    }

    public function findStatus3_4_5()
    {
        $qb = $this->createQueryBuilder('o')
            ->andWhere('o.status > 3')
            ->andWhere('o.status < 7');

        return $qb->getQuery()->getResult();
    }

    public function findByIds($ids)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Order[] Returns an array of Order objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Order
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
