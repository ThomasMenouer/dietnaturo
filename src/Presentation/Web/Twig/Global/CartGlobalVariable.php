<?php


namespace App\Presentation\Web\Twig\Global;

use App\Application\Shop\Service\CartService;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class CartGlobalVariable extends AbstractExtension implements GlobalsInterface
{
    public function __construct(private CartService $cartService) {}

    public function getGlobals(): array
    {
        return [
            'cartItemCount' => $this->cartService->getItemCount(),
        ];
    }
}