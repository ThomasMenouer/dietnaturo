<?php

namespace App\Application\Invoice\UseCase;


use App\Domain\Shop\Entity\Orders;
use App\Domain\Shop\Entity\Invoices;
use App\Domain\Shop\Interfaces\InvoicesRepositoryInterface;
use App\Application\Invoice\Service\InvoiceGeneratorService;

class CreateInvoiceUseCase
{
    public function __construct(
        private InvoicesRepositoryInterface $invoiceRepository,
        private InvoiceGeneratorService $invoiceGeneratorService
    ) {}

    public function execute(Orders $order): Invoices
    {
        $invoice = $this->invoiceGeneratorService->createInvoice($order);

        $this->invoiceRepository->save($invoice);

        return $invoice;

    }
}

