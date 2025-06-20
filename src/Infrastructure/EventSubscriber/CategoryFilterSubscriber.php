<?php

namespace App\Infrastructure\EventSubscriber;

use App\Domain\Blog\Repository\CategoriesRepositoryInterface;
use Twig\Environment;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CategoryFilterSubscriber implements EventSubscriberInterface
{
    const ROUTES = ['blog_index', 'blog_category'];

    public function __construct(
        private CategoriesRepositoryInterface $categoriesRepositoryInterface,
        private Environment $twig

    ){}
    public function injectGlobalVariable(RequestEvent $event): void
    {
        $route = $event->getRequest()->get('_route');
        if (in_array($route, CategoryFilterSubscriber::ROUTES)){

            $categories = $this->categoriesRepositoryInterface->getAllCategories();
            $this->twig->addGlobal('allCategories', $categories);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'injectGlobalVariable',
        ];
    }
}
