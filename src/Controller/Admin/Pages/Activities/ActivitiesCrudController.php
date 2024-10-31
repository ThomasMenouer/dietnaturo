<?php

namespace App\Controller\Admin\Pages\Activities;

use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use App\Entity\Pages\Activities\Activities;
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
            TextEditorField::new('content')->hideOnIndex(),
            TextField::new('imageFile')->setFormType(VichImageType::class),
            ImageField::new('imageName')->setBasePath('/images/activities')->setUploadDir('public/images'),
        ];
    }
}
