<?php

namespace App\Controller\Admin;

use App\Entity\Blog\Articles;
use App\Entity\Ateliers\Ateliers;
use App\Entity\Blog\Categories;
use App\Entity\Pages\Consultations;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
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

        yield MenuItem::subMenu('Pages', 'fa-regular fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Voir Consultations', 'fa-regular fa-newspaper', Consultations::class),
        ]);

        yield MenuItem::subMenu('Blog', 'fa-regular fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Voir articles', 'fa-regular fa-newspaper', Articles::class),
            MenuItem::linkToCrud('Voir Categories', 'fas fa-eye', Categories::class),
        ]);

        yield MenuItem::subMenu('Atelier', 'fa-regular fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Voir Ateliers', 'fa-regular fa-newspaper', Ateliers::class),
        ]);
    }
}
