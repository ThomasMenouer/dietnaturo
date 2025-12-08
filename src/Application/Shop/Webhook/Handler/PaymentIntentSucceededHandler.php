<?php

namespace App\Application\Shop\Webhook\Handler;


use App\Application\Invoice\UseCase\CreateInvoiceUseCase;
use App\Application\Mailers\UseCase\SendInvoiceAndEbooksUseCase;
use App\Application\Shop\Orders\UseCase\UpdateOrderStatusUseCase;
use App\Application\Shop\Webhook\Interface\StripeEventHandlerInterface;

final class PaymentIntentSucceededHandler implements StripeEventHandlerInterface
{
    public function __construct(
        private UpdateOrderStatusUseCase $updateOrderStatusUseCase,
        private CreateInvoiceUseCase $createInvoiceUseCase,
        private SendInvoiceAndEbooksUseCase $sendInvoiceAndEbooksUseCase,
    ) {}

    public function supports(string $eventType): bool
    {
        return $eventType === 'payment_intent.succeeded';
    }

    public function handle(object $data): void
    {
        $reference = $data->metadata->order_reference ?? null;

        if ($reference) {
            $order = $this->updateOrderStatusUseCase->execute($reference, 'paid');
            $invoice = $this->createInvoiceUseCase->execute($order);
            $order->setInvoice($invoice);
            $this->sendInvoiceAndEbooksUseCase->execute($order);
        }
    }
}
