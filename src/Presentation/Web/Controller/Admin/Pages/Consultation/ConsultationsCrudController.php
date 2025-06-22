<?php

namespace App\Presentation\Web\Controller\Admin\Pages\Consultation;

use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use App\Domain\Pages\Entity\Consultation\Consultations;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


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
