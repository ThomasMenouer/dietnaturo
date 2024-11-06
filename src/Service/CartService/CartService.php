<?php

namespace App\Service\CartService;

use Symfony\Component\HttpFoundation\RequestStack;


class CartService{

    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack) {

        $this->requestStack = $requestStack;
        
    }

    public function addProduct(){

        $this->requestStack->getSession();
        

    }

    public function deleteProduct(){


    }

    public function removeCart(){

    }
}
