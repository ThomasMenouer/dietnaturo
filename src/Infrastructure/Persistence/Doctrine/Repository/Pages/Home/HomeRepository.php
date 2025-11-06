<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Pages\Home;


use App\Domain\Pages\Repository\HomeRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Pages\Entity\Home\Home;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Home>
 */
class HomeRepository extends ServiceEntityRepository implements HomeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Home::class);
    }

    public function getAllHomeContent(): array
    {
        return $this->findAll();
    }

}
