<?php

namespace App\Controller\Admin;

use App\Entity\Blog\Articles;
use App\Entity\Blog\Categories;
use App\Entity\Pages\Coaching\Coachings;
use App\Entity\Ateliers\Ateliers;
use App\Entity\Pages\Consultation\Consultations;
use App\Entity\Pages\Coaching\CycleCoachings;
use App\Entity\Pages\Consultation\DeroulementConsultation;
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

        yield MenuItem::subMenu('Consultation', 'fa-regular fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Voir consultations', 'fa-regular fa-newspaper', Consultations::class),
            MenuItem::linkToCrud('Voir déroulement consultation', 'fa-regular fa-newspaper', DeroulementConsultation::class),
        ]);

        yield MenuItem::subMenu('Coaching', 'fa-regular fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Voir coachings', 'fa-regular fa-newspaper', Coachings::class),
            MenuItem::linkToCrud('Voir cycle coachings', 'fa-regular fa-newspaper', CycleCoachings::class),
        ]);

        yield MenuItem::subMenu('Blog', 'fa-regular fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Voir articles', 'fa-regular fa-newspaper', Articles::class),
            MenuItem::linkToCrud('Voir categories', 'fas fa-eye', Categories::class),
        ]);

        yield MenuItem::subMenu('Atelier', 'fa-regular fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Voir ateliers', 'fa-regular fa-newspaper', Ateliers::class),
        ]);
    }
}
