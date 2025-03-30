<?php

namespace App\Controller\Shop;

use App\Form\CheckoutType;
use App\Service\CartService\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\CheckoutService\CheckoutService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/commande', name: 'checkout_')]
class OrdersController extends AbstractController
{
    #[Route('/', name: 'resume')]
    public function index(Request $request, CartService $cartService, CheckoutService $checkoutService): Response
    {
        $cartData = $cartService->getCartData();

        if($cartData === []){
            return $this->redirectToRoute('cart_index');
        }

        $form = $this->createForm(CheckoutType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $checkoutService->processCheckout(
                $data['firstName'],
                $data['lastName'],
                $data['email'],
                $data['phoneNumber'],
            );

            // 4. Rediriger vers la page de confirmation
            return $this->redirectToRoute('checkout_resume');
         }

        return $this->render('shop/orders.html.twig', [
            'cartData' => $cartData,
            'form' => $form
            
        ]);

    }

}
