<?php

namespace App\EventSubscriber;

use App\Repository\Blog\CategoriesRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class CategoryFilterSubscriber implements EventSubscriberInterface
{
    const ROUTES = ['blog_index', 'blog_category'];

    public function __construct(
        private CategoriesRepository $categoriesRepository,
        private Environment $twig

    )
    {
        
    }
    public function injectGlobalVariable(RequestEvent $event): void
    {
        //dd($event->getRequest());
        $route = $event->getRequest()->get('_route');
        if (in_array($route, CategoryFilterSubscriber::ROUTES)){

            $categories = $this->categoriesRepository->findAll();
            //($categories);
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
