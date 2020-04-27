<?php

namespace App\Repository;

use App\Entity\AmazonReportRequests;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AmazonReportRequests|null find($id, $lockMode = null, $lockVersion = null)
 * @method AmazonReportRequests|null findOneBy(array $criteria, array $orderBy = null)
 * @method AmazonReportRequests[]    findAll()
 * @method AmazonReportRequests[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AmazonReportRequestsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AmazonReportRequests::class);
    }

    // /**
    //  * @return AmazonReportRequests[] Returns an array of AmazonReportRequests objects
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

    public function findPendingReports(): ?array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.reportStatus != :status')
            ->setParameter('status', '_DONE_')
            ->getQuery()
            ->getResult()
        ;
    }
}
