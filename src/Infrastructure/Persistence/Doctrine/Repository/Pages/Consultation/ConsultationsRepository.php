<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Pages\Consultation;


use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Pages\Entity\Consultation\Consultations;
use App\Domain\Pages\Repository\ConsultationsRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Consultations>
 *
 * @method Consultations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consultations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consultations[]    findAll()
 * @method Consultations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsultationsRepository extends ServiceEntityRepository implements ConsultationsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consultations::class);
    }

    public function save(Consultations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Consultations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Consultations[]
     */
    public function getAllConsultations(): array
    {
        return $this->findAll();
    }
}
