<?php

namespace App\Repository\Ateliers;

use App\Entity\Ateliers\Ateliers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ateliers>
 *
 * @method Ateliers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ateliers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ateliers[]    findAll()
 * @method Ateliers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AteliersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ateliers::class);
    }

    public function save(Ateliers $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Ateliers $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function countAllAteliers() {
        
        $qb = $this->createQueryBuilder('a')
        ->select('COUNT(a.id) as Value');

        $query = $qb->getQuery();

        return $query->getSingleResult();

        
    }

    public function countParticipantsByAtelierWithDate()
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a.title, a.date, a.price, COUNT(p.id) AS participant_count, (COUNT(p.id)*a.price) AS montant')
            ->leftJoin('a.participants', 'p')
            ->groupBy('a.id');
    
        return $qb->getQuery()->getResult();
    }
}