<?php

namespace App\Application\Mailers\UseCase;

use App\Domain\Mailer\SendMailInterface;
use App\Domain\Shop\Entity\Orders;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SendInvoiceAndEbooksUseCase
{
    public function __construct(private SendMailInterface $mailer, private ParameterBagInterface $params) {}

    public function execute(Orders $order): void
    {

        $ebooks = [];
        foreach ($order->getOrderDetails() as $detail) {

            $relativePath = $detail->getEbookPath();
            $path = $this->params->get('kernel.project_dir') . '/public' . $relativePath;

            if (file_exists($path)) {
                // On crée un tableau avec le chemin du fichier et le nom à afficher au client
                $ebooks[] = [
                    'path' => $path,
                    'name' => $detail->getProductName() . '.pdf'
                ];
            }
        }


        $this->mailer->sendInvoiceAndEbooks(
            $order->getEmail(),
            $order->getFirstname(),
            $order->getInvoice()->getPdfPath(),
            $ebooks

        );

    }
}
