<?php

namespace App\Repository;

use App\Entity\AmazonListing;
use App\Entity\ItemsWenko;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AmazonListing|null find($id, $lockMode = null, $lockVersion = null)
 * @method AmazonListing|null findOneBy(array $criteria, array $orderBy = null)
 * @method AmazonListing[]    findAll()
 * @method AmazonListing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AmazonListingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AmazonListing::class);
    }

    public function getItemsToRemove(): ?array
    {
        return $this->createQueryBuilder('amazon')
                    ->leftjoin(
                        ItemsWenko::class,
                        'wenko',
                        \Doctrine\ORM\Query\Expr\Join::WITH,
                        'wenko.sku = amazon.sku'
                    )
                    ->andWhere('wenko.sku IS NULL')
                    ->getQuery()
                    ->getResult()
            ;
    }
}
