<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Shop;

use App\Domain\Shop\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Shop\Interfaces\ProductsRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Products>
 */
class ProductsRepository extends ServiceEntityRepository implements ProductsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }

    public function getAllProducts(): array
    {
        return $this->findAll();
    }

    public function getEnabledProducts(): array
    {
        return $this->findBy(['enabled' => true]);
    }

    public function findById(int $id): ?Products
    {
        return $this->find($id);
    }
}
