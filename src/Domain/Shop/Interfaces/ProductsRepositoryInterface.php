<?php

namespace App\Domain\Shop\Interfaces;

use App\Domain\Shop\Entity\Products;

interface ProductsRepositoryInterface
{
    public function getAllProducts(): array;

    public function findById(int $id): ?Products;

}