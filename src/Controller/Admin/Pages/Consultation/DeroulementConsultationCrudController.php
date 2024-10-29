<?php

namespace App\Controller\Admin\Pages\Consultation;

use App\Entity\Pages\Consultation\DeroulementConsultation;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class DeroulementConsultationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DeroulementConsultation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('step'),
            TextField::new('title'),
            TextEditorField::new('content')->hideOnIndex(),
        ];
    }
}
