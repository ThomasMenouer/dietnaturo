<?php

namespace App\Presentation\Web\Controller\Admin\Ateliers;


use Symfony\Component\DomCrawler\Link;
use App\Domain\Ateliers\Entity\Ateliers;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use App\Presentation\Web\Form\SendEmailType;
use Symfony\Component\HttpFoundation\Request;
use App\Infrastructure\Mailer\EmailSendService;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use App\Presentation\Web\Form\Admin\ParticipantsAdminType;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AteliersCrudController extends AbstractCrudController
{
    public function __construct(
        private EmailSendService $emailSendService, 
        private AdminUrlGenerator $adminUrlGenerator)
    {
        $this->emailSendService = $emailSendService;
        $this->adminUrlGenerator = $adminUrlGenerator;
        
    }

    public static function getEntityFqcn(): string
    {
        return Ateliers::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $sendEmails = Action::new('sendEmailsToParticipants', 'Envoyer un email aux participants', 'fa fa-envelope')
        ->linkToCrudAction('sendEmailsToParticipants')
        ->addCssClass('btn btn-primary');

        $deleteParticipants = Action::new('deleteParticipants', 'Supprimer les participants')
        ->linkToCrudAction('DeleteParticipants')
        ->setCssClass('btn btn-danger');

        return $actions
            ->add(Crud::PAGE_EDIT, $sendEmails)
            ->add(Crud::PAGE_EDIT, $deleteParticipants);
    }

    public function configureFields(string $pageName): iterable
    {
        return [

            FormField::addTab('Atelier'),

            TextField::new('title', 'Titre'),
            TextField::new('theme', 'Thème')->addCssClass('col-6'),
            TextField::new('imageFile', 'Image')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('imageName', 'Image')->setBasePath('/images/ateliers')->setUploadDir('public/images')->hideOnForm(),
            TextEditorField::new('content', 'Au programme')->hideOnIndex(),

            MoneyField::new('price', 'Prix')->setCurrency('EUR')
            ->addCssClass('col-3'),

            IntegerField::new('places', 'Nombre de places')
            ->addCssClass('col-3'),

            SlugField::new('slug')->setTargetFieldName('title')->hideOnIndex(),
            BooleanField::new('isAvailable', 'Atelier disponible'),
            BooleanField::new('isVisio', 'Atelier en visio'),

            UrlField::new('link', 'Lien de l\'atelier en visio')
                ->setHelp('Si l\'atelier est en visio, ajoutez le lien de la réunion ici.')
                ->hideOnIndex(),

            FormField::addTab('Date Ateliers')
            ->setHelp('⚠️ Lors de la suppression d\'une date, vous supprimez également tous les participants inscrits à cette date.'),

            
            DateTimeField::new('date', 'date'),
            
            FormField::addTab('Inscriptions'),
            
            CollectionField::new('Participants', 'Participants inscrits')
                ->allowAdd(true)
                ->allowDelete(true)
                ->setEntryType(ParticipantsAdminType::class)
                ->setFormTypeOption('entry_options', [
                    'atelier' => $this->getContext()->getEntity()->getInstance(),
                ]
            ),
        ];
    }

    /**
     * Summary of sendEmailsToParticipants
     * @param \EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext $context
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function sendEmailsToParticipants(AdminContext $context, Request $request)
    {
        // Récupérer l'entité Atelier depuis le contexte
        $atelier = $context->getEntity()->getInstance();


        $form = $this->createForm(SendEmailType::class);
        $form->handleRequest($request);
    
        // Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $subject = $data['subject'];
            $content = $data['content'];

            // Récupérer tous les participants inscrits à cet atelier
            $participants = $atelier->getParticipants()->toArray();

            if (empty($participants)) {
                $this->addFlash('info', 'Aucun participant inscrit pour cet atelier.');
                return $this->redirect($this->generateUrl('admin', [
                    'crudAction' => Crud::PAGE_EDIT,
                    'entityId' => $atelier->getId(),
                ]));
            }
    
            // Envoyer les e-mails à chaque participant
            $this->emailSendService->sendEmailToAllParticipants(
                $participants,
                $subject,
                $content
            );
            
            $url = $this->adminUrlGenerator
            ->setController(AteliersCrudController::class)
            ->setAction(Action::INDEX)
            ->generateUrl();
    
            $this->addFlash('success', 'Emails envoyés avec succès aux participants.');
            return $this->redirect($url);
        }

        // Afficher le formulaire s'il n'est pas encore soumis
        return $this->render('admin/sendEmail.html.twig', [
            'form' => $form->createView(),
            'atelier' => $atelier,
        ]);
    }

    public function DeleteParticipants(AdminContext $context, EntityManagerInterface $em){

        $atelier = $context->getEntity()->getInstance();

        if (!$atelier instanceof Ateliers) {
            $this->addFlash('danger', 'Cette entité n\'est pas un atelier.');
            return $this->redirect($context->getReferrer());
        }
        
        // Supprimer tous les participants liés à cet atelier
        foreach ($atelier->getParticipants() as $participant) {
            $em->remove($participant);
        }

        $em->flush();

        $this->addFlash('success', 'Tous les participants associés à cet atelier ont été supprimés.');
    
        $url = $this->adminUrlGenerator
        ->setController(AteliersCrudController::class)
        ->setAction(Action::INDEX)
        ->generateUrl();

        return $this->redirect($url);
    }
}
