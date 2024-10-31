<?php

namespace App\Controller\Admin\Pages\Consultation;

use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use App\Entity\Pages\Consultation\DeroulementConsultation;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DeroulementConsultationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DeroulementConsultation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('step'),
            TextField::new('title'),
            TextEditorField::new('content')->hideOnIndex(),
            TextField::new('imageFile')->setFormType(VichImageType::class),
            ImageField::new('imageName')->setBasePath('/images/consultations')->setUploadDir('public/images'),
        ];
    }
}
