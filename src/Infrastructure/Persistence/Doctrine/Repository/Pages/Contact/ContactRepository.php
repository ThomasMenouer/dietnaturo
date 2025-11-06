<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Pages\Contact;


use App\Domain\Pages\Repository\ContactRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Pages\Entity\Contact\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Contact>
 */
class ContactRepository extends ServiceEntityRepository implements ContactRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function getAllContact(): array
    {
        return $this->findAll();
    }

}
