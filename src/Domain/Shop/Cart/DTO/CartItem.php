<?php

namespace App\Domain\Shop\Cart\DTO;

class CartItem
{
    public function __construct(
        private int $productId,
        private int $quantity
    ) {}

    public function getProductId(): int 
    { 
        return $this->productId; 
    }

    public function getQuantity(): int 
    { 
        return $this->quantity; 
    }
}