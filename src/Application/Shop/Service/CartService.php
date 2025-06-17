<?php


namespace App\Application\Shop\Service;

use App\Domain\Shop\Cart\Repository\CartStorageInterface;
use App\Infrastructure\Persistence\Doctrine\Repository\Shop\ProductsRepository;



class CartService
{
    public function __construct(
        private CartStorageInterface $cartStorage,
        private ProductsRepository $productsRepository
    ) {}

    public function addProduct(int $id): void
    {
        $cart = $this->cartStorage->getCart();

        $cart[$id] = ($cart[$id] ?? 0) + 1;

        $this->cartStorage->updateCart($cart);
    }

    public function deleteProduct(int $id): void
    {
        $cart = $this->cartStorage->getCart();

        if (!isset($cart[$id])) return;

        if ($cart[$id] > 1) {
            $cart[$id]--;
        } else {
            unset($cart[$id]);
        }

        $this->cartStorage->updateCart($cart);
    }

    public function removeProduct(int $id): void
    {
        $cart = $this->cartStorage->getCart();
        unset($cart[$id]);
        $this->cartStorage->updateCart($cart);
    }

    public function clearCart(): void
    {
        $this->cartStorage->clearCart();
    }

    public function getCartData(): array
    {
        $cart = $this->cartStorage->getCart();
        $cartData = [];

        foreach ($cart as $id => $quantity) {
            $product = $this->productsRepository->find($id);
            if ($product) {
                $cartData[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }
        }

        return $cartData;
    }

    public function getPriceHTC(): int
    {
        return array_reduce($this->getCartData(), function ($total, $item) {
            return $total + $item['product']->getPrice() * $item['quantity'];
        }, 0);
    }

    public function getItemCount(): int
    {
        return array_reduce($this->getCartData(), fn ($sum, $item) => $sum + $item['quantity'], 0);
    }
}
