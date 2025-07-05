<?php


namespace App\Application\Shop\Orders\UseCase;

use App\Domain\Shop\Entity\Orders;
use App\Domain\Shop\Cart\Repository\OrdersRepositoryInterface;

final class GetOrdersByReferenceUseCase
{
    public function __construct(private OrdersRepositoryInterface $ordersRepository){}

    public function execute(string $reference): ?Orders
    {
        return $this->ordersRepository->findByReference($reference);
    }
}