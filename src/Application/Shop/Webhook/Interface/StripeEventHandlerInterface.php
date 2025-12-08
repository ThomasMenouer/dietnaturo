<?php

namespace App\Application\Shop\Webhook\Interface;

/**
 * Contrat que doivent implémenter tous les handlers d’événements Stripe.
 * 
 * Principe :
 * - supports(string $eventType): indique si ce handler gère l’événement
 * - handle(object $eventData): exécute la logique pour cet événement
 */
interface StripeEventHandlerInterface
{
    public function supports(string $eventType): bool;
    public function handle(object $eventData): void;
}
