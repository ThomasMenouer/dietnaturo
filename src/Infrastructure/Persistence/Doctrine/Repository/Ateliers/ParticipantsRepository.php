<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Ateliers;


use App\Domain\Ateliers\Entity\Ateliers;
use App\Domain\Ateliers\Repository\ParticipantsRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Ateliers\Entity\Participants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Participants>
 *
 * @method Participants|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participants|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participants[]    findAll()
 * @method Participants[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipantsRepository extends ServiceEntityRepository implements ParticipantsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry, private EntityManagerInterface $em)
    {
        parent::__construct($registry, Participants::class);
    }

    public function save(Participants $participant): void
    {
        $this->getEntityManager()->persist($participant);
        $this->getEntityManager()->flush();
    }

    public function remove(Participants $participants): void
    {
        $this->getEntityManager()->remove($participants);
        $this->getEntityManager()->flush();
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

    public function findOneByEmailAndAtelier(string $email, Ateliers $atelier): ?Participants
    {
        return $this->findOneBy([
            'email' => $email,
            'ateliers' => $atelier,
        ]);
    }
}
