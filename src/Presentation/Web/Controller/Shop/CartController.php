<?php

namespace App\Presentation\Web\Controller\Shop;


use App\Domain\Shop\Entity\Products;
use App\Application\Shop\Service\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/panier', name: 'cart_')]
class CartController extends AbstractController
{
    #[Route('/', name:'index')]
    public function index(CartService $cartService): Response
    {
        return $this->render('cart/cart.html.twig', [
            'cartData' => $cartService->getCartData(),
            'TotalHTC' => $cartService->getPriceHTC()
        ]);
    }


    #[Route('/add/{id}', name: 'add')]
    public function add(CartService $cartService, #[MapEntity(mapping: ['id' => 'id'])] Products $product): Response{

        $cartService->addProduct($product->getId());
        
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(CartService $cartService, #[MapEntity(mapping: ['id' => 'id'])] Products $product): Response{

        $cartService->deleteProduct($product->getId());
        
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/remove', name: 'remove')]
    public function removeCart(CartService $cartService){

        $cartService->clearCart();

        return $this->redirectToRoute('cart_index');
    }


    #[Route('/remove/{id}', name: 'remove_product')]
    public function removeProduct(CartService $cartService, #[MapEntity(mapping: ['id' => 'id'])] Products $product): Response{

        $cartService->removeProduct($product->getId());
        
        return $this->redirectToRoute('cart_index');
    }


}
