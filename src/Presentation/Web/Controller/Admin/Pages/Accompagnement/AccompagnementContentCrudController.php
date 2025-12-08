<?php

namespace App\Presentation\Web\Controller\Admin\Pages\Accompagnement;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use App\Domain\Pages\Entity\Accompagnement\AccompagnementContent;
use BcMath\Number;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class AccompagnementContentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AccompagnementContent::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre'),

            TextEditorField::new('content', 'Contenu')
                ->hideOnIndex(),

            IntegerField::new('position', 'Ordre d’affichage du texte'),

            TextField::new('imageFile', 'Image')
                ->setFormType(VichImageType::class)
                ->hideOnIndex(),

            ImageField::new('imageName', 'Image')
                ->setBasePath('/images/accompagnementContent')
                ->setUploadDir('public/images')
                ->hideOnForm(),

            AssociationField::new('accompagnement', 'Accompagnement')
                ->setCrudController(AccompagnementCrudController::class),
        ];
    }
}
