<?php

namespace App\Application\Invoice\Service;

use Dompdf\Dompdf;
use Dompdf\Options;
use Twig\Environment;
use App\Domain\Shop\Entity\Orders;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class InvoiceGeneratorService
{
    public function __construct(
        private Environment $twig,
        private ParameterBagInterface $params
    ) {}

    public function createInvoice(Orders $order): string
    {
        $dompdf = new Dompdf();

        // 1. Render HTML with Twig
        $html = $this->twig->render('invoices/invoice.html.twig', [
            'order' => $order
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // 2. Save PDF to a file
        $invoiceDir = $this->params->get('kernel.project_dir') . '/var/invoices/';
        (new Filesystem())->mkdir($invoiceDir);

        $filePath = $invoiceDir . 'invoice_' . $order->getReference() . '.pdf';
        file_put_contents($filePath, $dompdf->output());

        return $filePath;
    }
}
