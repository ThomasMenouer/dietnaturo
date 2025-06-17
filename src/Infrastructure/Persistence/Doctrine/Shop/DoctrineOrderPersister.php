<?php

namespace App\Infrastructure\Persistence\Doctrine\Shop;


use App\Domain\Shop\Order\Order;
use App\Domain\Shop\Entity\Orders;
use App\Domain\Shop\Entity\OrderDetails;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Shop\Cart\Repository\OrderPersisterInterface;



class DoctrineOrderPersister implements OrderPersisterInterface
{
    public function __construct(private EntityManagerInterface $em) {}

    public function save(Order $order): void
    {
        $orders = new Orders();
        $orders->setReference($order->reference);
        $orders->setFirstname($order->firstname);
        $orders->setLastname($order->lastname);
        $orders->setEmail($order->email);
        $orders->setPhoneNumber($order->phoneNumber);
        $orders->setTotalPrice($order->totalPrice);

        foreach ($order->items as $item) {
            $detail = new OrderDetails();
            $detail->setOrders($orders);
            $detail->setProductName($item->productName);
            $detail->setQuantity($item->quantity);
            $detail->setPrice($item->price);

            $orders->addOrderDetail($detail);
        }

        $this->em->persist($orders);
        $this->em->flush();
    }
}
