<?php

namespace App\Presentation\Web\Twig\Global;

use App\Application\Shop\Service\CartService;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class CartGlobalVariable extends AbstractExtension implements GlobalsInterface
{
    public function __construct(
        private CartService $cartService,
        private RequestStack $requestStack
    ) {}

    public function getGlobals(): array
    {
        // Ne charge le panier QUE si on est dans un contexte HTTP (pas en CLI/Messenger)
        $request = $this->requestStack->getCurrentRequest();
        
        if (!$request) {
            // Contexte CLI/Messenger : retourne 0
            return [
                'cartItemCount' => 0,
            ];
        }

        // Contexte HTTP : charge le vrai panier
        try {
            return [
                'cartItemCount' => $this->cartService->getItemCount(),
            ];
        } catch (\Exception $e) {
            // Fallback en cas d'erreur
            return [
                'cartItemCount' => 0,
            ];
        }
    }
}