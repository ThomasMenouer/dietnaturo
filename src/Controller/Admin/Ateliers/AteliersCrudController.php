<?php

namespace App\Controller\Admin\Ateliers;

use App\Entity\Ateliers\Ateliers;
use App\Form\Admin\ParticipantsAdminType;
use App\Form\Admin\DatesAteliersAdminType;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
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
            TextField::new('title'),
            TextField::new('theme'),
            TextEditorField::new('content')->hideOnIndex(),
            //MoneyField::new('price')->setCurrency('EUR'),
            SlugField::new('slug')->setTargetFieldName('title'),
            BooleanField::new('isAvailable'),

            FormField::addTab('Date Ateliers')
            ->setHelp('⚠️ Lors de la suppression d\'une date, vous supprimez également tous les participants inscrits à cette date.'),
            CollectionField::new('datesDisponibles')
                ->setHelp('📅 Vous pouvez ajouter plusieurs dates pour un même atelier.')
                ->allowAdd(true)
                ->allowDelete(true)
                ->setEntryType(DatesAteliersAdminType::class)
                ->setFormTypeOption('by_reference', false),
            
            FormField::addTab('Inscriptions'),
            CollectionField::new('Participants')
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
