<?php

namespace App\Repository\Ateliers;

use App\Entity\Ateliers\Ateliers;
use App\Entity\Ateliers\Participants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Participants>
 *
 * @method Participants|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participants|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participants[]    findAll()
 * @method Participants[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipantsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participants::class);
    }

    public function save(Participants $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Participants $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
     * Récupère tous les emails des participants.
     *
     * @return string[]
     */
    public function findAllEmails(): array
    {
        $qb = $this->createQueryBuilder('i')
            ->select('i.email');

        return array_column($qb->getQuery()->getResult(), 'email');
    }

    /**
     * Récupère les emails des participants pour un atelier donné.
     *
     * @param Ateliers $atelier
     * @return string[]
     */
    public function findEmailsByAtelier(Ateliers $ateliers): array
    {
        $qb = $this->createQueryBuilder('i')
            ->select('i.email')
            ->where('i.ateliers = :ateliers')
            ->setParameter('ateliers', $ateliers);

        return array_column($qb->getQuery()->getResult(), 'email');
    }
}
