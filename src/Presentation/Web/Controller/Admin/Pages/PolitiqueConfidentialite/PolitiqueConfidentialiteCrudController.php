<?php


namespace App\Presentation\Web\Controller\Admin\Pages\PolitiqueConfidentialite;


use App\Domain\Pages\Entity\PolitiqueConfidentialite\PolitiqueConfidentialite;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PolitiqueConfidentialiteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PolitiqueConfidentialite::class;
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
