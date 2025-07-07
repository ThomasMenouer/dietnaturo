<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Shop;

use App\Domain\Shop\Entity\ProductsEbook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductsEbook>
 */
class ProductsEbookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductsEbook::class);
    }

}
