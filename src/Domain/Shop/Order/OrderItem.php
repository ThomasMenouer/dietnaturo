<?php

namespace App\Domain\Shop\Order;

class OrderItem
{
    public function __construct(
        public string $productName,
        public int $quantity,
        public int $price
    ) {}
}
