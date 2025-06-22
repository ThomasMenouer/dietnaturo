<?php


namespace App\Domain\Shop\Cart\Repository;

interface CartStorageInterface
{
    public function getCart(): array;
    public function updateCart(array $cart): void;
    public function clearCart(): void;
}
