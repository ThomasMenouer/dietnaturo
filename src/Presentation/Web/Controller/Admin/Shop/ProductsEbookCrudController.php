<?php

namespace App\Presentation\Web\Controller\Admin\Shop;

use App\Domain\Shop\Entity\ProductsEbook;
use Vich\UploaderBundle\Form\Type\VichFileType;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


class ProductsEbookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductsEbook::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('product', 'Produit'),
            Field::new('file')->setFormType(VichFileType::class)->hideOnIndex(),
            TextField::new('fileName')->onlyOnIndex(),
        ];
    }
}
