<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Shop;



use App\Domain\Shop\Entity\Invoices;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Shop\Interfaces\InvoicesRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Invoices>
 */
class InvoicesRepository extends ServiceEntityRepository implements InvoicesRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invoices::class);
    }

    public function save(Invoices $invoice): void
    {
        $this->getEntityManager()->persist($invoice);
        $this->getEntityManager()->flush();
    }

    public function getAllInvoices(): array
    {
        return $this->findAll();
    }




}
