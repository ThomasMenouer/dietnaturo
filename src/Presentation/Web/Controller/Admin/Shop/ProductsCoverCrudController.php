<?php

namespace App\Presentation\Web\Controller\Admin\Shop;

use App\Domain\Shop\Entity\ProductsCover;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductsCoverCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductsCover::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('product', 'Produit'),
            TextField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('imageName')
                ->setBasePath('/images/products/covers')
                ->setUploadDir('public/images/products/covers')
                ->hideOnForm(),
        ];
    }
}
