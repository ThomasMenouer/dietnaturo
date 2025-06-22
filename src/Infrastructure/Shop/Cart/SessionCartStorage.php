<?php

namespace App\Infrastructure\Shop\Cart;

use Symfony\Component\HttpFoundation\RequestStack;
use App\Domain\Shop\Cart\Repository\CartStorageInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionCartStorage implements CartStorageInterface
{
    public function __construct(private RequestStack $requestStack) {}

    public function getCart(): array
    {
        return $this->getSession()->get('cart', []);
    }

    public function updateCart(array $cart): void
    {
        $this->getSession()->set('cart', $cart);
    }

    public function clearCart(): void
    {
        $this->getSession()->remove('cart');
    }

    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }
}
