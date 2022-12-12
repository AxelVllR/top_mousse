<?php

namespace App\Repository;

use App\Entity\ResellerOrder;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResellerOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResellerOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResellerOrder[]    findAll()
 * @method ResellerOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResellerOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResellerOrder::class);
    }

    public function findByYear($year)
    {
        return $this->createQueryBuilder('r')
            ->where('YEAR(r.createdAt) = :year')
            ->setParameter('year', $year)
            ->getQuery()
            ->getResult();
    }

    public function getResellerByOrderNumberBetweenTwoValues($orderNumber1, $orderNumber2){
        return $this->createQueryBuilder('r')
            ->where('r.orderNumber >= :orderNumber1 AND r.orderNumber <= :orderNumber2')
            ->setParameter('orderNumber1', $orderNumber1)
            ->setParameter('orderNumber2', $orderNumber2)
            ->getQuery()
            ->getResult();
    }

    public function findByPeriod($start, $end)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.createdAt BETWEEN :start AND :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->andWhere('r.status = 8')
            ->getQuery()
            ->getResult();
    }

    public function findAllLimit($limit, string $orderNumber = null)
    {
        $qb = $this->createQueryBuilder('r')
            ->setMaxResults($limit)
            ->andWhere('r.status != 1')
            ->andWhere('r.status != 8');

        if($orderNumber) {
            $qb->andWhere('r.orderNumber = :orderNumber')
                ->setParameter('orderNumber', $orderNumber);
        }

        return $qb->getQuery()->getResult();
    }

    public function findStatus3_4_5()
    {
        $qb = $this->createQueryBuilder('r')
            ->andWhere('r.status > 3')
            ->andWhere('r.status < 7');

        return $qb->getQuery()->getResult();
    }

    public function findByDateInAndOutStateAndReseller(DateTime $dateStart, DateTime $dateEnd, string $email, string $status ){

        $qb = $this->createQueryBuilder('r')
            ->andWhere('r.createdAt BETWEEN :dateStart AND :dateEnd')
            ->setParameter('dateStart', $dateStart)
            ->setParameter('dateEnd', $dateEnd)
            ->andWhere('r.status = :status')
            ->setParameter('status', (int)$status)
            ->andWhere('r.email = :reseller')
            ->setParameter('reseller', $email);
        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return ResellerOrder[] Returns an array of ResellerOrder objects
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

    /*
    public function findOneBySomeField($value): ?ResellerOrder
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
