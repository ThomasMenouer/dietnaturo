<?php

namespace App\Application\Shop\Webhook;

use Psr\Log\LoggerInterface;
use App\Application\Shop\Webhook\Interface\StripeEventHandlerInterface;

final class StripeEventDispatcher
{
    /**
     * @param iterable<StripeEventHandlerInterface> $handlers
     */
    public function __construct(
        private iterable $handlers,
        private LoggerInterface $logger
    ) {}

    public function dispatch(string $type, object $data): void
    {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($type)) {
                $handler->handle($data);
                return;
            }
        }

        $this->logger->info('Unhandled Stripe event type: ' . $type);
    }
}
