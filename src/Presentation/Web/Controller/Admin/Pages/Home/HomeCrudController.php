<?php

namespace App\Presentation\Web\Controller\Admin\Pages\Home;

use Vich\UploaderBundle\Form\Type\VichImageType;
use App\Domain\Pages\Entity\Home\Home;
use Dom\Text;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class HomeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Home::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('subtitle'),
            TextField::new('fullName'),
            TextField::new('consult'),
            TextEditorField::new('content')->hideOnIndex()->setTrixEditorConfig([
                'blockAttributes' => [
                    'default' => ['tagName' => 'p', 'class' => ''],
                ],

            ]),
            TextField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('imageName', 'Image')->setBasePath('/images/home')->setUploadDir('public/images')->hideOnForm(),
        ];
    }
}
