<?php

namespace App\Controller\Admin\Shop;

use App\Entity\Shop\Products;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Products::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom'),
            TextEditorField::new('description', 'Description')->hideOnIndex(),
            
            MoneyField::new('price', 'Prix')
            ->setCurrency('EUR'),
            
            TextField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('imageName')->setBasePath('/images/products')->setUploadDir('public/images')->hideOnForm(),
            AssociationField::new('categories', 'Catégorie'),
            SlugField::new('slug', 'Slug')->setTargetFieldName('name')->hideOnIndex(),
        ];
    }
}
