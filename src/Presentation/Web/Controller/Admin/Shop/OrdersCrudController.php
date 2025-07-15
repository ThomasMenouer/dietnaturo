<?php

namespace App\Presentation\Web\Controller\Admin\Shop;

use App\Domain\Shop\Entity\Orders;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrdersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Orders::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW);
        
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('reference', 'Référence')
                ->setHelp('Référence unique de la commande'),

            
            TextField::new('firstname', 'Prénom'),
            TextField::new('lastname', 'Nom'),
            EmailField::new('email'),
            
            MoneyField::new('totalPrice', 'Prix')->setCurrency('EUR'),
            
            AssociationField::new('invoice', 'Facture')
                ->setHelp('Facture liée à cette commande')
                ->onlyOnIndex(),

            CollectionField::new('orderDetails', 'Détails de  commande')
                ->onlyOnDetail(),

        ];
    }
}
