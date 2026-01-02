<?php

namespace App\Presentation\Web\Controller\Admin;


use App\Domain\Shop\Entity\Orders;
use App\Domain\Shop\Entity\Invoices;
use App\Domain\Shop\Entity\Products;
use App\Domain\Pages\Entity\Faqs\Faqs;
use App\Domain\Pages\Entity\Home\Home;
use App\Domain\Ateliers\Entity\Ateliers;
use App\Domain\Pages\Entity\About\About;
use App\Domain\Shop\Entity\OrderDetails;
use App\Domain\Pages\Entity\About\Approche;
use App\Domain\Pages\Entity\Contact\Contact;
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
use App\Domain\Pages\Entity\Accompagnement\Accompagnement;
use App\Domain\Pages\Entity\Consultation\PriceConsultations;
use App\Domain\Pages\Entity\MentionsLegales\MentionsLegales;
use App\Domain\NewsletterSubscriber\Entity\NewsletterSubscriber;
use App\Domain\Pages\Entity\Accompagnement\AccompagnementContent;
use App\Domain\Pages\Entity\Consultation\DeroulementConsultation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use App\Domain\Pages\Entity\ConditionsGeneralesVente\ConditionsGeneralesVente;
use App\Domain\Pages\Entity\PolitiqueConfidentialite\PolitiqueConfidentialite;
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
        // Lien vers le dashboard

        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        // Index des pages du site
        
        yield MenuItem::section('Pages du site');


        yield MenuItem::linkToCrud('Home', 'fa-solid fa-list-ol', Home::class);
    
        yield MenuItem::subMenu('A propos', 'fa-solid fa-list-ol')->setSubItems([
            MenuItem::linkToCrud('Voir à propos', 'fa-solid fa-pencil', About::class),
            MenuItem::linkToCrud('Voir mon approche', 'fa-solid fa-list-ol', Approche::class),
        ]);

        yield MenuItem::linkToCrud('Activités', 'fa-solid fa-list-ol', Activities::class);

        yield MenuItem::linkToCrud('FAQs', 'fa-solid fa-question', Faqs::class);

        yield MenuItem::linkToCrud('Contact', 'fa-solid fa-list-ol', Contact::class);

        yield MenuItem::subMenu('Consultation', 'fa-solid fa-hand-holding-heart')->setSubItems([
            MenuItem::linkToCrud('Voir consultations', 'fa-solid fa-pencil', Consultations::class),
            MenuItem::linkToCrud('Voir déroulement consultation', 'fa-solid fa-bars-staggered', DeroulementConsultation::class),
            MenuItem::linkToCrud('Voir prix consultations', 'fa-solid fa-money-bill', PriceConsultations::class),
        ]);

        yield MenuItem::subMenu('Accompagnement', 'fa-solid fa-list-ol')->setSubItems([
            MenuItem::linkToCrud('Accompagnement', 'fa-solid fa-list-ol', Accompagnement::class),
            MenuItem::linkToCrud('Accompagnement Content', 'fa-solid fa-file-lines', AccompagnementContent::class),
        ]);

        yield MenuItem::subMenu('Coaching', 'fa-solid fa-dumbbell')->setSubItems([
            MenuItem::linkToCrud('Voir coachings', 'fa-solid fa-dumbbell', Coachings::class),
            MenuItem::linkToCrud('Voir cycle coachings', 'fa-solid fa-bars-staggered', CycleCoachings::class),
        ]);

        yield MenuItem::subMenu('Pages légales', 'fa-solid fa-file-contract')->setSubItems([
            MenuItem::linkToCrud('Voir mentions légales', 'fa-solid fa-pencil', MentionsLegales::class),
            MenuItem::linkToCrud('Voir politique de confidentialité', 'fa-solid fa-pencil', PolitiqueConfidentialite::class),
            MenuItem::linkToCrud('Voir conditions générales de vente', 'fa-solid fa-pencil', ConditionsGeneralesVente::class),
        ]);

        // Index Ateliers et Boutique

        yield MenuItem::section('Ateliers');

        yield MenuItem::subMenu('Atelier', 'fa-solid fa-people-group')->setSubItems([
            MenuItem::linkToCrud('Voir ateliers', 'fa-solid fa-leaf', Ateliers::class),
            MenuItem::linkToCrud('Newsletter', 'fa-solid fa-newspaper', NewsletterSubscriber::class),
        ]);

        yield MenuItem::section('Boutique');

        yield MenuItem::subMenu('Boutique', 'fa-solid fa-bag-shopping')->setSubItems([
            MenuItem::linkToCrud('Voir produits', 'fa-regular fa-file', Products::class),
            MenuItem::linkToCrud('Voir categories', 'fa-solid fa-tags', CategoriesProducts::class),
        ]);

        yield MenuItem::subMenu('Commandes', 'fas fa-box')->setSubItems([
            MenuItem::linkToCrud('Voir Commandes', 'fas fa-shopping-bag', Orders::class),
            MenuItem::linkToCrud('Voir Détail de la commande', 'fas fa-shopping-bag', OrderDetails::class),
            MenuItem::linkToCrud('Facture', 'fa-solid fa-file-invoice', Invoices::class),
        ]);

        // Retour au site
        yield MenuItem::section('');

        yield MenuItem::linkToRoute('Retour au site', 'fa fa-undo', 'home');
    }
}
