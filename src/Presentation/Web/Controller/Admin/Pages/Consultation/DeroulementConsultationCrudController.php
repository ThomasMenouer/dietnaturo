<?php

namespace App\Presentation\Web\Controller\Admin\Pages\Consultation;

use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use App\Domain\Pages\Entity\Consultation\DeroulementConsultation;
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
