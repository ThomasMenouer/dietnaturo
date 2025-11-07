<?php

namespace App\Presentation\Web\Controller\Admin\Newsletter;

use App\Application\Newsletter\UseCase\GetAllEmailsUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Infrastructure\Mailer\EmailSendService;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use App\Domain\NewsletterSubscriber\Entity\NewsletterSubscriber;
use App\Presentation\Web\Form\Admin\Newsletter\NewsletterAdminType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use App\Infrastructure\Persistence\Doctrine\Repository\NewsletterRepository\NewsletterSubscriberRepository;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class NewsletterCrudController extends AbstractCrudController
{
    public function __construct(
        private EmailSendService $emailSendService,
        private AdminUrlGenerator $adminUrlGenerator
    ) {}

    public static function getEntityFqcn(): string
    {
        return NewsletterSubscriber::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle(Crud::PAGE_INDEX, 'Abonnés à la newsletter');
    }

    public function configureActions(Actions $actions): Actions
    {
        // Action globale en haut à droite de la page index
        $sendNewsletter = Action::new('sendNewsletter', 'Envoyer une newsletter', 'fa fa-envelope')
            ->linkToCrudAction('sendNewsletter') // lien vers notre méthode locale
            ->createAsGlobalAction(); // -> bouton global (en haut à droite)

        return $actions
            ->add(Crud::PAGE_INDEX, $sendNewsletter)
            ->disable(Action::NEW); // empêche l’ajout manuel d’un abonné
    }

    public function sendNewsletter(Request $request, GetAllEmailsUseCase $getAllEmailsUseCase): Response
    {
        $form = $this->createForm(NewsletterAdminType::class);
        $form->handleRequest($request);

        // Si formulaire soumis
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $subject = $data['subject'];
            $content = $data['content'];

            $subscribers = $getAllEmailsUseCase->execute();

            if (empty($subscribers)) {
                $this->addFlash('info', 'Aucun abonné à la newsletter.');
            } else {
                $this->emailSendService->sendEmailToAllSubscribers($subscribers, $subject, $content);
                $this->addFlash('success', 'Newsletter envoyée à tous les abonnés !');
            }

            // ✅ Redirection propre vers la page index de ce CRUD
            $url = $this->adminUrlGenerator
                ->setController(self::class)
                ->setAction(Crud::PAGE_INDEX)
                ->generateUrl();

            return $this->redirect($url);
        }

        // Sinon on affiche le formulaire
        return $this->render('admin/sendNewsletter.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}