<?php

namespace App\Application\Shop\Webhook\Handler;


use App\Application\Shop\Orders\UseCase\UpdateOrderStatusUseCase;
use App\Application\Shop\Webhook\Interface\StripeEventHandlerInterface;

final class PaymentIntentFailedHandler implements StripeEventHandlerInterface
{
    public function __construct(private UpdateOrderStatusUseCase $updateOrderStatusUseCase) {}

    public function supports(string $eventType): bool
    {
        return $eventType === 'payment_intent.payment_failed';
    }

    public function handle(object $data): void
    {
        $reference = $data->metadata->order_reference ?? null;
        if ($reference) {
            $this->updateOrderStatusUseCase->execute($reference, 'failed');
        }
    }
}
