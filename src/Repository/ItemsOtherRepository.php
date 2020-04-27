<?php

namespace App\Repository;

use App\Entity\ItemsOther;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ItemsOther|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemsOther|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemsOther[]    findAll()
 * @method ItemsOther[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemsOtherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemsOther::class);
    }
}
