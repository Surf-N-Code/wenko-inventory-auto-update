<?php

namespace App\Repository;

use App\Entity\AmazonListing;
use App\Entity\ItemsWenko;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ItemsWenko|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemsWenko|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemsWenko[]    findAll()
 * @method ItemsWenko[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemsWenkoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemsWenko::class);
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

    public function getItemsToAdd(): ?array
    {
        return $this->createQueryBuilder('wenko')
            ->leftJoin(
                AmazonListing::class,
                'amazon',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'wenko.sku = amazon.sku'
            )
            ->andWhere('amazon.sku IS NULL')
            ->andWhere('wenko.price > 17.98')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getItemsToUpdate(): ?array
    {
        return $this->createQueryBuilder('wenko')
                    ->innerJoin(
                        AmazonListing::class,
                        'amazon',
                        \Doctrine\ORM\Query\Expr\Join::WITH,
                        'wenko.sku = amazon.sku'
                    )
                    ->orWhere('wenko.price != amazon.price')
                    ->orWhere('wenko.stock != amazon.stock')
                    ->getQuery()
                    ->getResult()
            ;
    }
}
