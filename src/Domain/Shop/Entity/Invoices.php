<?php

namespace App\Domain\Shop\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Shop\Entity\Orders;
use App\Infrastructure\Persistence\Doctrine\Repository\Shop\InvoicesRepository;



#[ORM\Entity(repositoryClass: InvoicesRepository::class)]
class Invoices
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type: 'string', unique: true)]
    private string $invoiceNumber;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $issuedAt;

    #[ORM\Column(type: 'string')]
    private string $pdfPath;

    #[ORM\OneToOne(targetEntity: Orders::class, cascade: ['persist'], inversedBy: 'invoice')]
    #[ORM\JoinColumn(nullable: false)]
    private Orders $order;

    public function __construct(Orders $order, string $invoiceNumber, string $pdfPath)
    {
        $this->order = $order;
        $this->invoiceNumber = $invoiceNumber;
        $this->issuedAt = new \DateTimeImmutable();
        $this->pdfPath = $pdfPath;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getInvoiceNumber(): string
    {
        return $this->invoiceNumber;
    }

    public function getIssuedAt(): \DateTimeImmutable
    {
        return $this->issuedAt;
    }

    public function getPdfPath(): string
    {
        return $this->pdfPath;
    }

    public function getOrder(): Orders
    {
        return $this->order;
    }
}
