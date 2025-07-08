<?php

namespace App\Application\Shop\Service;


use App\Domain\Shop\Entity\Orders;
use App\Domain\Shop\Entity\OrderDetails;
use App\Domain\Shop\Cart\Repository\OrdersRepositoryInterface;

class CheckoutService
{
    public function __construct(
        private CartService $cartService,
        private OrdersRepositoryInterface $ordersRepositoryInterface,
    ) {}


    public function createOrderFromStripeSession($fullSession): Orders
    {
        $order = new Orders();
        $order->setReference($fullSession->metadata->order_reference);
        $order->setFirstname($fullSession->metadata->firstname);
        $order->setLastname($fullSession->metadata->lastname);
        $order->setEmail($fullSession->customer_email);
        $order->setTotalPrice($fullSession->amount_total);
        $order->setStatus($fullSession->payment_status);
        $order->setCreatedAt(new \DateTimeImmutable());

        $cart = json_decode($fullSession->metadata->cart, true);

        foreach ($cart as $item) {
            $orderDetails = new OrderDetails();
            $orderDetails->setOrders($order);
            $orderDetails->setProductName($item['productName']);
            $orderDetails->setQuantity($item['quantity']);
            $orderDetails->setPrice($item['price']);
            $order->addOrderDetail($orderDetails);
        }

        $this->ordersRepositoryInterface->save($order);

        return $order;
    }
}
