<?php

namespace App\Presentation\Web\Controller\Admin\Pages\Faqs;

use App\Domain\Pages\Entity\Faqs\Faqs;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class FaqsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Faqs::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            
            TextField::new('question'),
            TextEditorField::new('answer'),
        ];
    }
}
