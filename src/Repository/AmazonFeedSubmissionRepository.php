<?php

namespace App\Repository;

use App\Entity\AmazonFeedSubmission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AmazonFeedSubmission|null find($id, $lockMode = null, $lockVersion = null)
 * @method AmazonFeedSubmission|null findOneBy(array $criteria, array $orderBy = null)
 * @method AmazonFeedSubmission[]    findAll()
 * @method AmazonFeedSubmission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AmazonFeedSubmissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AmazonFeedSubmission::class);
    }

    // /**
    //  * @return AmazonFeedSubmission[] Returns an array of AmazonFeedSubmission objects
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
    public function findOneBySomeField($value): ?AmazonFeedSubmission
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
