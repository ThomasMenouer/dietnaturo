<?php

namespace App\Controller\Admin\Pages\Faqs;

use App\Entity\Faqs;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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
