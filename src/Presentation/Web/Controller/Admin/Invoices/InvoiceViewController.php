<?php

namespace App\Presentation\Web\Controller\Admin\Invoices;

use App\Domain\Shop\Entity\Invoices;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_ADMIN')]
class InvoiceViewController extends AbstractController
{
    #[Route('/admin/invoices/{id}/view', name: 'admin_invoice_view')]
    public function viewInvoice(#[MapEntity] Invoices $invoice): Response
    {
        $filePath = $invoice->getPdfPath();

        return $this->file($filePath, null, 'inline');
    }
}
