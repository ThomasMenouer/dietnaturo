<?php

namespace App\Controller\Shop;

use App\Service\CartService\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrdersController extends AbstractController
{
    #[Route('/commande', name: 'checkout')]
    public function index(CartService $cartService): Response
    {

        $cartData = $cartService->getCartData();
        
        if( $cartData === []){

           return $this->redirectToRoute('cart_index');

        }else{

            #$checkoutService->processCheckout($email);
        }
    
    }
}
