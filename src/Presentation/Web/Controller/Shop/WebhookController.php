<?php


namespace App\Presentation\Web\Controller\Shop;

use Stripe\Stripe;
use Stripe\Webhook;
use Psr\Log\LoggerInterface;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Application\Shop\Service\CheckoutService;
use App\Application\Invoice\UseCase\CreateInvoiceUseCase;
use App\Application\Mailers\UseCase\SendInvoiceAndEbooksUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class WebhookController extends AbstractController
{

    #[Route('/stripe/webhook', name: 'stripe_webhook', methods: ['POST'])]
    public function handleWebhook(
        Request $request, 
        CheckoutService $checkoutService, 
        CreateInvoiceUseCase $createInvoiceUseCase,
        SendInvoiceAndEbooksUseCase $sendInvoiceAndEbooksUseCase,
        LoggerInterface $logger
        ): Response
    {
        Stripe::setApiKey($this->getParameter('stripe.secret_key'));

        $payload = $request->getContent();
        $signature = $request->headers->get('stripe-signature');
        $secret = $this->getParameter('stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $signature, $secret);
        } catch (\Exception $e) {
            return new Response('Invalid signature: ' . $e->getMessage(), 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            try {

                $fullSession = Session::retrieve($session->id);

                $order = $checkoutService->createOrderFromStripeSession($fullSession);

                // Create invoice
                $invoice = $createInvoiceUseCase->execute($order);

                $order->setInvoice($invoice);

                // send email with invoice and ebooks
                $sendInvoiceAndEbooksUseCase->execute($order);

            } catch (\Exception $e) {
                $logger->error('Stripe webhook error: ' . $e->getMessage(), [
                    'exception' => $e,
                    'payload' => $payload,
                ]);
                return new Response('Order creation failed', 500);
            }
        }

        return new Response('Webhook handled', 200);
    }
}
