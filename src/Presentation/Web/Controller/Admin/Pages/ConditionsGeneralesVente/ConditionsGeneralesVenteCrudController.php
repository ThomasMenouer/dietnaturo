<?php

namespace App\Presentation\Web\Controller\Admin\Pages\ConditionsGeneralesVente;

use App\Domain\Pages\Entity\ConditionsGeneralesVente\ConditionsGeneralesVente;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ConditionsGeneralesVenteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ConditionsGeneralesVente::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('content')->hideOnIndex()->setTrixEditorConfig([
                'blockAttributes' => [
                    'default' => ['tagName' => 'p', 'class' => ''],
                ],
            ]),
        ];
    }
}
