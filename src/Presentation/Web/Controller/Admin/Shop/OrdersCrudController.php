<?php

namespace App\Presentation\Web\Controller\Admin\Shop;

use Dom\Text;
use App\Domain\Shop\Entity\Orders;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
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

            DateTimeField::new('createdAt', 'Date de création')
                ->setHelp('Date de création de la commande'),

            TextField::new('firstname', 'Prénom')
                ->setHelp('Prénom du client')
                ->hideOnIndex(),



            TextField::new('lastname', 'Nom')
                ->setHelp('Nom du client')
                ->hideOnIndex(),

            EmailField::new('email'),

            TextField::new('status', 'Statut')
                ->setHelp('Statut actuel de la commande'),


            MoneyField::new('totalPrice', 'Prix total')->setCurrency('EUR'),

        ];
    }
}
