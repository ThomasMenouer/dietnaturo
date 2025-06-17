<?php

namespace App\Presentation\Web\Controller\Admin\Pages\Activities;

use Vich\UploaderBundle\Form\Type\VichImageType;
use App\Domain\Pages\Entity\Activities\Activities;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ActivitiesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Activities::class;
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
            TextField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('imageName', 'Image')->setBasePath('/images/activities')->setUploadDir('public/images')->hideOnForm(),
        ];
    }
}
