<?php

namespace App\Presentation\Web\Controller\Admin\Shop;

use App\Domain\Shop\Entity\OrderDetails;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderDetailsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrderDetails::class;
    }

        public function configureActions(Actions $actions): Actions
        {
            return $actions
                ->disable(Action::NEW);
        }

    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('orders.reference', 'Référence de la commande')
                ->setSortable(true)
                ->setHelp('Référence de la commande associée'),

            TextField::new('productName', 'Nom du produit'),

            IntegerField::new('quantity', 'Quantité')
                ->setHelp('Quantité de produit dans la commande'),
            
            MoneyField::new('price', 'Prix unitaire')
                ->setCurrency('EUR')
                ->setHelp('Prix unitaire du produit'),

        ];
    }
}
