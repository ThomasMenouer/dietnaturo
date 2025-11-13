<?php

namespace App\Presentation\Web\Controller\Admin\Pages\Accompagnement;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use App\Domain\Pages\Entity\Accompagnement\Accompagnement;
use App\Presentation\Web\Form\Admin\AccompagnementContentAdminType;

class AccompagnementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Accompagnement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre'),
            SlugField::new('slug')->setTargetFieldName('title'),
        ];
    }
}
