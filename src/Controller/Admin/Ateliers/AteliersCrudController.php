<?php

namespace App\Controller\Admin\Ateliers;

use App\Entity\Ateliers\Ateliers;
use App\Form\Admin\ParticipantsAdminType;
use App\Form\Admin\DatesAteliersAdminType;
use App\Service\MailerService\EmailSendService;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AteliersCrudController extends AbstractCrudController
{
    private $emailSendService;
    // public function __construct(EmailSendService $emailSendService)
    // {
    //     $this->emailSendService = $emailSendService;
    // }
    public static function getEntityFqcn(): string
    {
        return Ateliers::class;
    }

    // public function configureActions(Actions $actions): Actions
    // {
    //     $sendEmails = Action::new('sendEmails', 'Envoyer un email', 'fa fa-envelope')
    //     ->linkToCrudAction('SendEmails')
    //     ->displayAsButton()
    //     ->addCssClass('btn btn-primary');

    //     return $actions
    //         ->add(Crud::PAGE_EDIT, $sendEmails);
    // }

    public function configureFields(string $pageName): iterable
    {
        return [

            FormField::addTab('Atelier'),

            TextField::new('title', 'Titre'),
            TextField::new('theme', 'Thème'),
            TextField::new('imageFile', 'Image')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('imageName', 'Image')->setBasePath('/images/products')->setUploadDir('public/images')->hideOnForm(),
            TextEditorField::new('content', 'Au programme')->hideOnIndex(),
            //MoneyField::new('price')->setCurrency('EUR'),
            SlugField::new('slug')->setTargetFieldName('title'),
            BooleanField::new('isAvailable', 'Atelier disponible'),

            
            FormField::addTab('Date Ateliers')
            ->setHelp('⚠️ Lors de la suppression d\'une date, vous supprimez également tous les participants inscrits à cette date.'),
            
            CollectionField::new('datesDisponibles', 'Dates disponibles')
                ->setHelp('📅 Vous pouvez ajouter plusieurs dates pour un même atelier.')
                ->allowAdd(true)
                ->allowDelete(true)
                ->setEntryType(DatesAteliersAdminType::class)
                ->setFormTypeOption('by_reference', false),
            
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

    
}
