<?php

namespace App\Repository;

use App\Entity\ItemUpdateStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ItemUpdateStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemUpdateStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemUpdateStatus[]    findAll()
 * @method ItemUpdateStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemUpdateStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemUpdateStatus::class);
    }

    // /**
    //  * @return ItemUpdateStatus[] Returns an array of ItemUpdateStatus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ItemUpdateStatus
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
