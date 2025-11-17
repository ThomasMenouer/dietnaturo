<?php

namespace App\Presentation\Web\Controller\Admin\Pages\Consultation;

use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

use App\Domain\Pages\Entity\Consultation\PriceConsultations;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PriceConsultationsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PriceConsultations::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Titre'),

            MoneyField::new('price', 'Prix')
                ->setCurrency('EUR'),

            TextField::new('category', 'Catégorie')
                ->setHelp('Exemple : "Diététique / Naturopathique", "Soins énergétiques"'),

            TextEditorField::new('description', 'Description'),
            
        ];
    }
}
