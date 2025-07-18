<?php


namespace App\Application\Shop\Service;

use App\Domain\Shop\Cart\Repository\OrdersRepositoryInterface;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\RequestStack;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StripePaymentService
{
    public function __construct(
        private readonly CartService $cartService, 
        private readonly UrlGeneratorInterface $urlGenerator, 
        private readonly UploaderHelper $uploaderHelper,
        private readonly RequestStack $requestStack,
        private readonly OrdersRepositoryInterface $ordersRepository,
        string $stripeSecretKey
    ) {
        Stripe::setApiKey($stripeSecretKey);
    }

    public function createCheckoutSession(array $cartData, array $infoCustomer): string
    {
        // $request = $this->requestStack->getCurrentRequest();
        $lineItems = [];
        $orderReference = uniqid('order_');

        foreach ($cartData as $item) {
            // $imagePath = $this->uploaderHelper->asset($item['product'], 'imageFile');
            // $fullImageUrl = $request->getSchemeAndHttpHost() . $imagePath;

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item['product']->getName(),
                        // 'images' => [$fullImageUrl],
                    ],
                    'unit_amount' => $item['product']->getPrice(),
                ],
                'quantity' => $item['quantity'],
            ];
        }

        $session = Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'customer_email' => $infoCustomer['email'],
            'metadata' => [
                'firstname' => $infoCustomer['firstName'],
                'lastname' => $infoCustomer['lastName'],
                'order_reference' => $orderReference,
                'cart' => json_encode(array_map(fn ($item) => [
                    'productName' => $item['product']->getName(),
                    'quantity' => $item['quantity'],
                    'price' => $item['product']->getPrice(),
                    'ebookPath' => $item['product']->getFirstEbookPath(),
                ], $cartData)),
            ],
            'success_url' => $this->urlGenerator->generate('checkout_success', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->urlGenerator->generate('cart_index', ['reference' => $orderReference], UrlGeneratorInterface::ABSOLUTE_URL)
        ]);

        return $session->url;
    }


}
