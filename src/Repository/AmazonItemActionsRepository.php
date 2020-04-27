<?php

namespace App\Repository;

use App\Entity\AmazonItemActions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AmazonItemActions|null find($id, $lockMode = null, $lockVersion = null)
 * @method AmazonItemActions|null findOneBy(array $criteria, array $orderBy = null)
 * @method AmazonItemActions[]    findAll()
 * @method AmazonItemActions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AmazonItemActionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AmazonItemActions::class);
    }

    // /**
    //  * @return ItemsWenko[] Returns an array of ItemsWenko objects
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
    public function findOneBySomeField($value): ?ItemsWenko
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
