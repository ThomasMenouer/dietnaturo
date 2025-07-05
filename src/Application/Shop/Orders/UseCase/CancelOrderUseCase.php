<?php


namespace App\Application\Shop\Orders\UseCase;

use App\Domain\Shop\Enum\OrderStatus;
use App\Domain\Shop\Cart\Repository\OrdersRepositoryInterface;



final class CancelOrderUseCase
{
    public function __construct(
        private OrdersRepositoryInterface $ordersRepository
    ) {}

    public function execute(string $reference): void
    {
        $order = $this->ordersRepository->findByReference($reference);

        if (!$order || $order->getStatus() !== OrderStatus::PENDING->value) {
            throw new \DomainException('Commande introuvable ou déjà traitée.');
        }

        $order->setStatus(OrderStatus::CANCELLED->value);

        $this->ordersRepository->save($order);
    }
}