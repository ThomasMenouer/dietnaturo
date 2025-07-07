<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Shop;

use App\Domain\Shop\Entity\ProductsCover;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductsCover>
 * 
 */
class ProductsCoverRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductsCover::class);
    }

}
