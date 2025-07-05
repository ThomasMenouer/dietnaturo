<?php


namespace App\Presentation\Web\Controller\Shop;

use App\Application\Shop\Orders\UseCase\CancelOrderUseCase;
use App\Domain\Shop\Enum\OrderStatus;
use App\Application\Shop\Service\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Application\Shop\Orders\UseCase\GetOrdersByReferenceUseCase;

#[Route('/paiement', name: 'checkout_')]
final class StripeController extends AbstractController
{
    #[Route('/success', name: 'success')]
    public function success(CartService $cartService): Response
    {
        $cartService->clearCart();

        return $this->render('shop/payment_success.html.twig');
    }

    #[Route('/cancel/{reference}', name: 'cancel')]
    public function cancel(string $reference, CancelOrderUseCase $cancelOrderUseCase): Response
    {
        try {
            $cancelOrderUseCase->execute($reference);
            $this->addFlash('warning', 'Le paiement a été annulé. Vous pouvez réessayer.');
        } catch (\DomainException $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        return $this->redirectToRoute('cart_index');
    }
}