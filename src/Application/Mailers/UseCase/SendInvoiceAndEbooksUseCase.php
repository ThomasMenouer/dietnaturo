<?php

namespace App\Application\Mailers\UseCase;

use App\Domain\Mailer\SendMailInterface;
use App\Domain\Shop\Entity\Orders;

class SendInvoiceAndEbooksUseCase
{
    public function __construct(private SendMailInterface $mailer) {}

    public function execute(Orders $order): void
    {
        $this->mailer->sendInvoiceAndEbooks(
            $order->getEmail(), 
            $order->getFirstname(), 
            $order->getInvoice()->getPdfPath()
        );

    }
}
