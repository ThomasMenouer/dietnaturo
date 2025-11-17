<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Pages\About;


use App\Domain\Pages\Repository\AboutRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Pages\Entity\About\About;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<About>
 */
class AboutRepository extends ServiceEntityRepository implements AboutRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, About::class);
    }

    public function getAllAbout(): array
    {
        return $this->findAll();
    }

}
