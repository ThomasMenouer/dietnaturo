<?php

namespace App\Presentation\Web\Controller\Shop;

use App\Application\Shop\Products\UseCase\GetEnabledProductsUseCase;
use App\Domain\Shop\Entity\Products;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/boutique', 'shop_')]
class ShopController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(GetEnabledProductsUseCase $getEnabledProductsUseCase): Response
    {
        // Page en maintenance
        return $this->render('maintenance/maintenance.html.twig');

        // $products = $getEnabledProductsUseCase->execute();

        // return $this->render('shop/shop.html.twig', [
        //     'products' => $products

        // ]);
    }

    #[Route('/{slug}', name: 'product')]
    public function product(#[MapEntity(mapping: ['slug' => 'slug'])] Products $product): Response
    {
        return $this->render('shop/product.html.twig', [
            'product' => $product
        ]);
    }
}
