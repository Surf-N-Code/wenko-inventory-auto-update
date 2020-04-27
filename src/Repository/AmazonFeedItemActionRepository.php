<?php

namespace App\Repository;

use App\Entity\AmazonFeedItemAction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AmazonFeedItemAction|null find($id, $lockMode = null, $lockVersion = null)
 * @method AmazonFeedItemAction|null findOneBy(array $criteria, array $orderBy = null)
 * @method AmazonFeedItemAction[]    findAll()
 * @method AmazonFeedItemAction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AmazonFeedItemActionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AmazonFeedItemAction::class);
    }

    // /**
    //  * @return AmazonFeedItemAction[] Returns an array of AmazonFeedItemAction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AmazonFeedItemAction
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
