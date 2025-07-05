<?php 

namespace App\Domain\Shop\Cart\Repository;

use App\Domain\Shop\Entity\Orders;


interface OrdersRepositoryInterface
{
    public function save(Orders $order): void;

    public function findByReference(string $reference): ?Orders;
    
}
