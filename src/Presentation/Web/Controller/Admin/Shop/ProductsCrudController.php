<?php

namespace App\Presentation\Web\Controller\Admin\Shop;

use App\Domain\Shop\Entity\Products;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use App\Presentation\Web\Form\Admin\ProductsCoverAdminType;
use App\Presentation\Web\Form\Admin\ProductsEbookAdminType;
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
            SlugField::new('slug', 'Slug')->setTargetFieldName('name')->hideOnIndex(),
            TextEditorField::new('description', 'Description')->hideOnIndex(),
            MoneyField::new('price', 'Prix')->setCurrency('EUR'),
            AssociationField::new('categories', 'Catégorie'),
            BooleanField::new('enabled', 'Actif'),

            ImageField::new('imagePath', 'Couverture')
                ->onlyOnIndex(),

            CollectionField::new('covers', 'Images de couverture')
                ->setEntryType(ProductsCoverAdminType::class)
                ->allowAdd()
                ->allowDelete()
                ->hideOnIndex(),

            CollectionField::new('ebooks', 'Ebooks')
                ->setEntryType(ProductsEbookAdminType::class)
                ->allowAdd()
                ->allowDelete()
                ->hideOnIndex(),
        ];
    }
}
