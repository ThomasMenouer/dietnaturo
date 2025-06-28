<?php


namespace App\Application\Shop\Service;

use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripePaymentService
{
    public function __construct(private string $stripeSecretKey)
    {
        Stripe::setApiKey($stripeSecretKey);
    }

    public function createCheckoutSession(array $cartData): Session
    {
        $lineItems = [];

        foreach ($cartData as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item['product']->getTitle(),
                    ],
                    'unit_amount' => $item['product']->getPrice(), // Attention : prix en centimes
                ],
                'quantity' => $item['quantity'],
            ];
        }

        return Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => 'https://tonsite.com/commande/success',
            'cancel_url' => 'https://tonsite.com/panier',
        ]);
    }
}
