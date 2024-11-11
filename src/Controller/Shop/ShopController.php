<?php

namespace App\Controller\Shop;

use App\Entity\Shop\Products;
use App\Repository\Shop\ProductsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/boutique', 'shop_')]
class ShopController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProductsRepository $productsRepository): Response
    {

        $products = $productsRepository->findAll();

        return $this->render('shop/shop.html.twig', [
            'products' => $products

        ]);
    }

    #[Route('/{slug}', name: 'product')]
    public function product(#[MapEntity(mapping: ['slug' => 'slug'])] Products $product): Response
    {
        return $this->render('shop/product.html.twig', [
            'product' => $product
        ]);
    }
}
