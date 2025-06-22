<?php
namespace App\Application\Shop\Service;

use App\Domain\Shop\Order\Order;
use App\Domain\Shop\Order\OrderItem;
use App\Domain\Shop\Cart\Repository\OrderPersisterInterface;



class CheckoutService
{
    public function __construct(
        private CartService $cartService,
        private OrderPersisterInterface $orderPersister
    ) {}

    public function processCheckout(string $firstname, string $lastname, string $email, string $phoneNumber): void
    {
        $order = new Order();
        $order->reference = uniqid();
        $order->firstname = $firstname;
        $order->lastname = $lastname;
        $order->email = $email;
        $order->phoneNumber = $phoneNumber;
        $order->totalPrice = $this->cartService->getPriceHTC();

        foreach ($this->cartService->getCartData() as $item) {
            $order->items[] = new OrderItem(
                $item['product']->getName(),
                $item['quantity'],
                $item['product']->getPrice()
            );
        }

        $this->orderPersister->save($order);
    }
}
