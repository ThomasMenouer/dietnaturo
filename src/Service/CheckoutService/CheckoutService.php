<?php

namespace App\Service\CheckoutService;

use App\Entity\Shop\Orders;
use App\Entity\Shop\OrderDetails;
use App\Service\CartService\CartService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class CheckoutService{

    public function __construct(private EntityManagerInterface $em, private CartService $cartService) {
        $this->em = $em;
        $this->cartService = $cartService;
    }

    public function processCheckout(string $firstname, string $lastname, string $email, string $phoneNumber): void{

        # 1. Create order

        $order = new Orders();
        $order->setFirstname($firstname);
        $order->setLastname($lastname);
        $order->setEmail($email);
        $order->setPhoneNumber($phoneNumber);
        $order->setTotalPrice($this->cartService->getPriceHTC()); # REVOIR

        # Générer la référence ...
        $order->setReference(uniqid());


        foreach ($this->cartService->getCartdata() as $product) {
            // dd($product);
            $orderDetail = new OrderDetails();
            $orderDetail->setOrders($order);
            $orderDetail->setProductName($product['product']->getName());
            $orderDetail->setQuantity($product['quantity']);
            $orderDetail->setPrice($product['product']->getPrice());

            $order->addOrderDetail($orderDetail);
            
        }

        $this->em->persist($order);
        $this->em->flush();

        # 2 paiement ...


    }
}