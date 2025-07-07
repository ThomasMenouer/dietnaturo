<?php

namespace App\Presentation\Web\Controller\Admin;


use App\Domain\Blog\Entity\Articles;
use App\Domain\Shop\Entity\Products;
use App\Domain\Blog\Entity\Categories;
use App\Domain\Pages\Entity\Faqs\Faqs;
use App\Domain\Ateliers\Entity\Ateliers;
use App\Domain\Shop\Entity\ProductsCover;
use App\Domain\Shop\Entity\ProductsEbook;
use App\Domain\Shop\Entity\CategoriesProducts;
use Symfony\Component\HttpFoundation\Response;
use App\Domain\Pages\Entity\Coaching\Coachings;
use Symfony\Component\Routing\Annotation\Route;
use App\Domain\Pages\Entity\Activities\Activities;
use App\Domain\Pages\Entity\Coaching\CycleCoachings;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use App\Domain\Pages\Entity\Consultation\Consultations;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Domain\Pages\Entity\Consultation\PriceConsultations;
use App\Domain\Pages\Entity\Consultation\DeroulementConsultation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use App\Infrastructure\Persistence\Doctrine\Repository\Ateliers\AteliersRepository;

#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractDashboardController
{

    public function __construct(private AteliersRepository $ateliersRepository){

        $this->ateliersRepository = $ateliersRepository;
    }
    
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'countAllAteliers' => $this->ateliersRepository->countAllAteliers(),
            'countParticipantsByAtelierWithDate' => $this->ateliersRepository->countParticipantsByAtelierWithDate(),
        ]);
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

        yield MenuItem::linkToCrud('FAQs', 'fa-solid fa-question', Faqs::class);

        yield MenuItem::subMenu('Consultation', 'fa-solid fa-hand-holding-heart')->setSubItems([
            MenuItem::linkToCrud('Voir consultations', 'fa-solid fa-pencil', Consultations::class),
            MenuItem::linkToCrud('Voir déroulement consultation', 'fa-solid fa-bars-staggered', DeroulementConsultation::class),
            MenuItem::linkToCrud('Voir prix consultations', 'fa-solid fa-money-bill', PriceConsultations::class),
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
            MenuItem::linkToCrud('Covers', 'fa fa-image', ProductsCover::class),
            MenuItem::linkToCrud('Ebooks', 'fa fa-file-pdf', ProductsEbook::class),
            MenuItem::linkToCrud('Voir categories', 'fa-solid fa-tags', CategoriesProducts::class),
        ]);
    }
}
