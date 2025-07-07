<?php

namespace App\Application\Shop\Products\UseCase;

use App\Domain\Shop\Interfaces\ProductsRepositoryInterface;



final class GetEnabledProductsUseCase
{
    public function __construct(
        private readonly ProductsRepositoryInterface $productsRepository
    ) {}

    public function execute(): array
    {
        return $this->productsRepository->getEnabledProducts();
    }
}