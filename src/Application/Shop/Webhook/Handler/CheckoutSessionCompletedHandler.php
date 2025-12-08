<?php

namespace App\Application\Shop\Webhook\Handler;

use Psr\Log\LoggerInterface;
use Stripe\Checkout\Session;
use App\Application\Shop\Service\CheckoutService;
use App\Application\Shop\Webhook\Interface\StripeEventHandlerInterface;

final class CheckoutSessionCompletedHandler implements StripeEventHandlerInterface
{
    public function __construct(
        private CheckoutService $checkoutService,
        private LoggerInterface $logger
    ) {}

    public function supports(string $eventType): bool
    {
        return $eventType === 'checkout.session.completed';
    }

    public function handle(object $data): void
    {
        $fullSession = Session::retrieve($data->id);
        $order = $this->checkoutService->createOrderFromStripeSession($fullSession);
        $this->logger->info('Order created (pending)', ['reference' => $order->getReference()]);
    }
}
