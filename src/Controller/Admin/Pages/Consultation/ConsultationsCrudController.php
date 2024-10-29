<?php

namespace App\Controller\Admin\Pages\Consultation;

use App\Entity\Pages\Consultation\Consultations;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class ConsultationsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Consultations::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('content')->hideOnIndex(),
        ];
    }
}
