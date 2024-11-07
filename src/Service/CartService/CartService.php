<?php

namespace App\Service\CartService;

use App\Entity\Shop\Products;
use App\Repository\Shop\ProductsRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CartService{

    private RequestStack $requestStack;
    private ProductsRepository $productsRepository;

    /**
     * CartService's constructor
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param \App\Repository\Shop\ProductsRepository $productsRepository
     */
    public function __construct(RequestStack $requestStack, ProductsRepository $productsRepository) {

        $this->requestStack = $requestStack;
        $this->productsRepository = $productsRepository;
        
    }

    /**
     * Add a product to the cart
     * @param int $id
     * @return void
     */
    public function addProduct(int $id){

        $cart = $this->requestStack->getSession()->get('cart', []);

        if(empty($cart[$id])){
            $cart[$id] = 1;
        }
        else{
            $cart[$id]++;
        }

        $this->getSession()->set('cart', $cart);

    }

    /**
     * Summary of deleteProduct
     * @return void
     */
    public function deleteProduct(int $id){

        $cart = $this->requestStack->getSession()->get('cart', []);

        if(!empty($cart[$id])){
            
            if($cart[$id] > 1){

                $cart[$id]--;

            }else{
                unset($cart[$id]);
            }
        }

        $this->getSession()->set('cart', $cart);
    }

    /**
     * Summary of removeProduct
     * @return void
     */
    public function removeProduct(int $id){

        $cart = $this->requestStack->getSession()->get('cart', []);

        if(!empty($cart[$id])){
            
            unset($cart[$id]);
        }

        $this->getSession()->set('cart', $cart);
    }

    /**
     * Summary of removeCart
     * @return void
     */
    public function removeCart(): void{

        $this->getSession()->remove('cart');
    }

    /**
     * Return the cart
     * @return array
     */
    public function getCart(): array{

        $cart = $this->getSession()->get('cart', []);
        $cartData = [];

        foreach($cart as $id => $quantity){
            $product = $this->productsRepository->find($id);

            $cartData[] = [

                'product' => $product,
                'quantity' => $quantity
            ];
        }

        return $cartData;
    }

    /**
     * Return the total price (HTC) of the cart
     * @return int
     */
    public function getPriceHTC(): int{

        $total = 0;

        foreach ($this->getCart() as $item) {
            
            $total += $item['product']->getPrice() * $item['quantity'];

        }

        return $total;
    }

    /**
     * Return the session
     * @return \Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }
}