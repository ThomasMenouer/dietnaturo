<?php

namespace App\Application\Shop\Products\UseCase;

use App\Domain\Shop\Interfaces\ProductsRepositoryInterface;



final class GetAllProductsUseCase
{
    public function __construct(
        private readonly ProductsRepositoryInterface $productsRepository
    ) {}

    public function getAllProducts(): array
    {
        return $this->productsRepository->getAllProducts();
    }
}