<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Shop;


use App\Domain\Shop\Cart\Repository\OrdersRepositoryInterface;
use App\Domain\Shop\Entity\Orders;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Orders>
 */
class OrdersRepository extends ServiceEntityRepository implements OrdersRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Orders::class);
    }

    public function save(Orders $order): void
    {
        $this->getEntityManager()->persist($order);
        $this->getEntityManager()->flush();
    }

    public function findByReference(string $reference): ?Orders
    {
        return $this->findOneBy(['reference' => $reference]);
    }



}
