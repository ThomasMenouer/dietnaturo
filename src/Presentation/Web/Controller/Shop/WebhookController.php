<?php


namespace App\Presentation\Web\Controller\Shop;

use App\Application\Invoice\Service\InvoiceGeneratorService;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Application\Shop\Service\CheckoutService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class WebhookController extends AbstractController
{

    #[Route('/stripe/webhook', name: 'stripe_webhook', methods: ['POST'])]
    public function handleWebhook(Request $request, CheckoutService $checkoutService, InvoiceGeneratorService $invoiceGeneratorService): Response
    {
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

        $payload = $request->getContent();
        $signature = $request->headers->get('stripe-signature');
        $secret = $_ENV['STRIPE_WEBHOOK_SECRET'];

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

                $invoicePath = $invoiceGeneratorService->createInvoice($order);


            } catch (\Exception $e) {
                return new Response('Order creation failed', 500);
            }
        }

        return new Response('Webhook handled', 200);
    }
}
