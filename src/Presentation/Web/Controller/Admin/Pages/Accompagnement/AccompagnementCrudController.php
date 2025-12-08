<?php

namespace App\Presentation\Web\Controller\Admin\Pages\Accompagnement;

use phpDocumentor\Reflection\Types\Integer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use App\Domain\Pages\Entity\Accompagnement\Accompagnement;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use App\Presentation\Web\Form\Admin\AccompagnementContentAdminType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class AccompagnementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Accompagnement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre'),
            IntegerField::new('pagePosition', 'Ordre d’affichage'),
            SlugField::new('slug')->setTargetFieldName('title'),

            AssociationField::new('contents', 'Contenus')
                ->setCrudController(AccompagnementContentCrudController::class)
                ->autocomplete(),
        ];
    }
}
