<?php

namespace App\Controller\Admin;

use App\Entity\Blog\Articles;
use App\Entity\Shop\Products;
use App\Entity\Blog\Categories;
use App\Entity\Ateliers\Ateliers;
use App\Entity\Shop\CategoriesProducts;
use App\Entity\Pages\Coaching\Coachings;
use App\Entity\Pages\Activities\Activities;
use App\Entity\Pages\Coaching\CycleCoachings;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pages\Consultation\Consultations;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use App\Entity\Pages\Consultation\DeroulementConsultation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Diet et Naturo');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::linkToCrud('Activités', 'fa-solid fa-list-ol', Activities::class);

        yield MenuItem::subMenu('Consultation', 'fa-solid fa-hand-holding-heart')->setSubItems([
            MenuItem::linkToCrud('Voir consultations', 'fa-solid fa-pencil', Consultations::class),
            MenuItem::linkToCrud('Voir déroulement consultation', 'fa-solid fa-bars-staggered', DeroulementConsultation::class),
        ]);

        yield MenuItem::subMenu('Coaching', 'fa-solid fa-dumbbell')->setSubItems([
            MenuItem::linkToCrud('Voir coachings', 'fa-solid fa-dumbbell', Coachings::class),
            MenuItem::linkToCrud('Voir cycle coachings', 'fa-solid fa-bars-staggered', CycleCoachings::class),
        ]);

        yield MenuItem::subMenu('Blog', 'fa fa-file-text')->setSubItems([
            MenuItem::linkToCrud('Voir articles', 'fa-regular fa-file-lines', Articles::class),
            MenuItem::linkToCrud('Voir categories', 'fa fa-tags', Categories::class),
        ]);

        yield MenuItem::subMenu('Atelier', 'fa-solid fa-people-group')->setSubItems([
            MenuItem::linkToCrud('Voir ateliers', 'fa-solid fa-leaf', Ateliers::class),
        ]);

        yield MenuItem::subMenu('Boutique', 'fa-solid fa-bag-shopping')->setSubItems([
            MenuItem::linkToCrud('Voir produits', 'fa-regular fa-file', Products::class),
            MenuItem::linkToCrud('Voir categories', 'fa-solid fa-tags', CategoriesProducts::class),
        ]);
    }
}
