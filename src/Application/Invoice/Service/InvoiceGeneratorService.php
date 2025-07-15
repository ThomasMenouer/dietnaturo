<?php

namespace App\Application\Invoice\Service;

use Dompdf\Dompdf;
use Twig\Environment;
use App\Domain\Shop\Entity\Orders;
use App\Domain\Shop\Entity\Invoices;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class InvoiceGeneratorService
{
    public function __construct(
        private Environment $twig,
        private ParameterBagInterface $params
    ) {}

    public function createInvoice(Orders $order): Invoices
    {
        $dompdf = new Dompdf();

        
        $invoiceNumber = 'INV-' . $order->getId() . '-' . date('Ymd') . '-' . $order->getReference();

        
        $html = $this->twig->render('invoices/invoice.html.twig', [
            'order' => $order,
            'invoiceNumber' => $invoiceNumber,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        
        $invoiceDir = $this->params->get('kernel.project_dir') . '/var/invoices/';
        (new Filesystem())->mkdir($invoiceDir);

        $filePath = $invoiceDir . $invoiceNumber . '.pdf';
        file_put_contents($filePath, $dompdf->output());

        return new Invoices($order, $invoiceNumber, $filePath);
    }
}
