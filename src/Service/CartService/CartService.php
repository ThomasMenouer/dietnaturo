<?php

namespace App\Service\CartService;

use App\Repository\Shop\ProductsRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CartService{

    /**
     * CartService's constructor
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param \App\Repository\Shop\ProductsRepository $productsRepository
     */
    public function __construct(private RequestStack $requestStack, private ProductsRepository $productsRepository) {

        $this->requestStack = $requestStack;
        $this->productsRepository = $productsRepository;
        
    }

    /**
     * Add a product to the cart
     * @param int $id
     * @return void
     */
    public function addProduct(int $id){

        $cart = $this->getCart();

        if(empty($cart[$id])){
            $cart[$id] = 1;
        }
        else{
            $cart[$id]++;
        }

        $this->updateCart($cart);

    }

    /**
     * Summary of deleteProduct
     * @return void
     */
    public function deleteProduct(int $id){

        $cart = $this->getCart();

        if(!empty($cart[$id])){
            
            if($cart[$id] > 1){

                $cart[$id]--;

            }else{
                unset($cart[$id]);
            }
        }

        $this->updateCart($cart);
    }

    /**
     * Summary of removeProduct
     * @return void
     */
    public function removeProduct(int $id){

        $cart = $this->getCart();

        if(!empty($cart[$id])){
            
            unset($cart[$id]);
        }

        $this->updateCart($cart);
    }

    /**
     * Summary of removeCart
     * @return void
     */
    public function removeCart(): void{

        $this->getSession()->remove('cart');
    }

    /**
     * Return the cart data
     * @return array
     */
    public function getCartData(): array{

        $cart = $this->getCart();
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

        foreach ($this->getCartData() as $item) {
            
            $total += $item['product']->getPrice() * $item['quantity'];

        }

        return $total;
    }

    /**
     * Summary of getItemCount
     * @return int
     */
    private function getItemCount(): int{

        $total = 0;

        foreach($this->getCartData() as $item){
            $total += $item['quantity'];
        }

        return $total;
    }

    /**
     * Summary of updateCart
     * @param array $cart
     * @return void
     */
    private function updateCart(array $cart): void{

        $this->getSession()->set('cart', $cart);
        $this->getSession()->set('totalItemCount', $this->getItemCount());
    }

    /**
     * return the cart
     * @return mixed
     */
    private function getCart(){

        $cart = $this->getSession()->get('cart', []);

        return $cart;
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