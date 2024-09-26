<?php

namespace App\Controller\Admin\Pages;

use App\Entity\Pages\Consultations;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class ConsultationsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Consultations::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('content')->hideOnIndex(),
            // BooleanField::new('isPublished'),
            // DateTimeField::new('datePublished')->setFormat('d/m/Y'),
            // TextField::new('imageFile')->setFormType(VichImageType::class),
            // ImageField::new('imageName')->setBasePath('/images/articles')->setUploadDir('public/images'),
            // SlugField::new('slug')->setTargetFieldName('title'),
        ];
    }
}
