<?php

namespace App\Presentation\Web\Controller\Admin\Invoices;

use App\Domain\Shop\Entity\Invoices;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class InvoicesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Invoices::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW);
    }

    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('invoiceNumber', 'Facture')
                ->formatValue(function ($value, Invoices $invoice) {
                    return sprintf(
                        '<a href="%s" target="_blank">%s</a>',
                        $this->generateUrl('admin_invoice_view', ['id' => $invoice->getId()]),
                        $invoice->getInvoiceNumber()
                    );
                })
                ->onlyOnIndex()
                ->renderAsHtml(),

            AssociationField::new('order', 'Commande liée'),
        ];
    }

}
