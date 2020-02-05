<?php

namespace App\Repository;

use App\Entity\ListingsAmazon;
use App\Entity\ItemsWenko;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ListingsAmazon|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListingsAmazon|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListingsAmazon[]    findAll()
 * @method ListingsAmazon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListingsAmazonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListingsAmazon::class);
    }

    public function getItemsToRemove(): ?array
    {
        return $this->createQueryBuilder('amazon')
                    ->leftjoin(
                        ItemsWenko::class,
                        'wenko',
                        \Doctrine\ORM\Query\Expr\Join::WITH,
                        'wenko.ean = amazon.ean'
                    )
                    ->andWhere('wenko.ean IS NULL')
                    ->getQuery()
                    ->getResult()
            ;
    }
}
