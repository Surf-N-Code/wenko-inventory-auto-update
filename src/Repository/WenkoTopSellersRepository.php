<?php

namespace App\Repository;

use App\Entity\WenkoTopSellers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WenkoTopSellers|null find($id, $lockMode = null, $lockVersion = null)
 * @method WenkoTopSellers|null findOneBy(array $criteria, array $orderBy = null)
 * @method WenkoTopSellers[]    findAll()
 * @method WenkoTopSellers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WenkoTopSellersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WenkoTopSellers::class);
    }

    // /**
    //  * @return WenkoTopSellers[] Returns an array of WenkoTopSellers objects
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
    public function findOneBySomeField($value): ?WenkoTopSellers
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
