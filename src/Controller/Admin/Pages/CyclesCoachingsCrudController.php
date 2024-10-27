<?php

namespace App\Controller\Admin\Pages;

use App\Entity\Pages\CycleCoachings;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class CyclesCoachingsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CycleCoachings::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('content')->hideOnIndex(),
            IntegerField::new('price')
        ];
    }
}
