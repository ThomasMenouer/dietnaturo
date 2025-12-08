<?php

namespace App\Application\Shop\Orders\UseCase;

use App\Domain\Shop\Entity\Orders;
use App\Domain\Shop\Cart\Repository\OrdersRepositoryInterface;

final class UpdateOrderStatusUseCase
{
    public function __construct(private OrdersRepositoryInterface $ordersRepository) {}

    public function execute(string $reference, string $status): Orders
    {
        $order = $this->ordersRepository->findByReference($reference);
        if (!$order) {
            throw new \RuntimeException("Order not found for reference $reference");
        }

        $order->setStatus($status);
        $this->ordersRepository->save($order);

        return $order;
    }
}
