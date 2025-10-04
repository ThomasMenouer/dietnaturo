<?php

namespace App\Presentation\Web\Controller\Admin\Pages\About;

use Vich\UploaderBundle\Form\Type\VichImageType;
use App\Domain\Pages\Entity\About\Approche;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ApprocheCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Approche::class;
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
            ImageField::new('imageName', 'Image')->setBasePath('/images/about')->setUploadDir('public/images')->hideOnForm(),
        ];
    }
}
