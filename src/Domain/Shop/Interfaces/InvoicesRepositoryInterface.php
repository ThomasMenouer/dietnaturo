<?php

namespace App\Domain\Shop\Interfaces;

use App\Domain\Shop\Entity\Invoices;

interface InvoicesRepositoryInterface
{
    public function getAllInvoices(): array;

    public function save(Invoices $invoice): void;

}