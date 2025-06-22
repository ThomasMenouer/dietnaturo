<?php 

namespace App\Domain\Shop\Cart\Repository;

use App\Domain\Shop\Order\Order;

interface OrderPersisterInterface
{
    public function save(Order $order): void;
}
