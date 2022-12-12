<?php

namespace App\Repository;

use App\Entity\Cutting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cutting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cutting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cutting[]    findAll()
 * @method Cutting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CuttingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cutting::class);
    }

    // /**
    //  * @return Cutting[] Returns an array of Cutting objects
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

    public function deleteAll(){
        $this->createQueryBuilder('c')
            ->delete()
            ->getQuery()
            ->execute();
    }

    /*
    public function findOneBySomeField($value): ?Cutting
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
