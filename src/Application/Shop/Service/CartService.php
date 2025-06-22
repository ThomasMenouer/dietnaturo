<?php


namespace App\Application\Shop\Service;

use App\Domain\Shop\Cart\Repository\CartStorageInterface;
use App\Domain\Shop\Interfaces\ProductsRepositoryInterface;



class CartService
{
    public function __construct(
        private CartStorageInterface $cartStorage,
        private ProductsRepositoryInterface $productsRepositoryInterface
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
            $product = $this->productsRepositoryInterface->findById($id);
            if ($product) {
                $cartData[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }
        }

        return $cartData;
    }

    /**
     * Return the total price (HTC) of the cart
     * @return int
     */
    public function getPriceHTC(): int
    {
        $total = 0;

        foreach ($this->getCartData() as $item) {
            
            $total += $item['product']->getPrice() * $item['quantity'];

        }

        return $total;
    }

    /**
     * Summary of getItemCount
     * @return int
     */
    public function getItemCount(): int{

        $total = 0;

        foreach($this->getCartData() as $item){
            $total += $item['quantity'];
        }

        return $total;
    }
}
