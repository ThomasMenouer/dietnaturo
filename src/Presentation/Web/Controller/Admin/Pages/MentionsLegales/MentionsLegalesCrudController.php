<?php

namespace App\Presentation\Web\Controller\Admin\Pages\MentionsLegales;

use Vich\UploaderBundle\Form\Type\VichImageType;
use App\Domain\Pages\Entity\MentionsLegales\MentionsLegales;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MentionsLegalesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MentionsLegales::class;
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
