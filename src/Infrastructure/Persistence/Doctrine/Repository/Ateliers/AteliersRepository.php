<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Ateliers;


use App\Domain\Ateliers\Entity\Ateliers;
use App\Domain\Ateliers\Repository\AteliersRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Ateliers>
 *
 * @method Ateliers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ateliers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ateliers[]    findAll()
 * @method Ateliers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AteliersRepository extends ServiceEntityRepository implements AteliersRepositoryInterface
{
    public function __construct(ManagerRegistry $registry, private EntityManagerInterface $em)
    {
        parent::__construct($registry, Ateliers::class);
        $this->em  = $em;
    }


    public function getAllAteliers(): array
    {
        return $this->findAll();
    }

    // public function getAtelierBySlug()
    // {

    // }

    public function save(Ateliers $atelier): void
    {
        $this->em->persist($atelier);
        $this->em->flush();

    }

    public function remove(Ateliers $atelier): void
    {
        $this->em->remove($atelier);
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
            ->select('a.title, a.date, a.price, a.places, COUNT(p.id) AS participant_count, (COUNT(p.id)*a.price) AS montant')
            ->leftJoin('a.participants', 'p')
            ->groupBy('a.id');
    
        return $qb->getQuery()->getResult();
    }
}