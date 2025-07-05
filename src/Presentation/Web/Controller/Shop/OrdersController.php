<?php

namespace App\Presentation\Web\Controller\Shop;


use App\Presentation\Web\Form\CheckoutType;
use App\Application\Shop\Service\CartService;
use App\Application\Shop\Service\CheckoutService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Application\Shop\Service\StripePaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/commande', name: 'checkout_')]
class OrdersController extends AbstractController
{
    #[Route('/', name: 'resume')]
    public function index(
        Request $request,
        CartService $cartService,
        StripePaymentService $stripePaymentService): Response
    {
        $cartData = $cartService->getCartData();

        if($cartData === []){
            return $this->redirectToRoute('cart_index');
        }

        $form = $this->createForm(CheckoutType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $infoCustomer = $form->getData();

            $checkoutUrl = $stripePaymentService->createCheckoutSession(
                $cartService->getCartData(),
                $infoCustomer,
            );

            return $this->redirect($checkoutUrl);
        }

        return $this->render('shop/orders.html.twig', [
            'cartData' => $cartData,
            'form' => $form
            
        ]);
    }
}
