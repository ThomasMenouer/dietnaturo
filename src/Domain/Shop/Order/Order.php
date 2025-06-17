<?php


namespace App\Domain\Shop\Order;

class Order
{
    public string $reference;
    public string $firstname;
    public string $lastname;
    public string $email;
    public string $phoneNumber;
    public int $totalPrice;
    
    /** @var OrderItem[] */
    public array $items = [];
}
