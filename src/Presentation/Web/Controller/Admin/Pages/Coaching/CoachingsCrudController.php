<?php

namespace App\Presentation\Web\Controller\Admin\Pages\Coaching;


use App\Domain\Pages\Entity\Coaching\Coachings;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CoachingsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Coachings::class;
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
