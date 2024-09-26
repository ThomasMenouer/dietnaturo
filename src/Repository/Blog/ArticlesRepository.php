<?php

namespace App\Repository\Blog;

use App\Entity\Blog\Articles;
use App\Entity\Blog\Categories;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Articles>
 *
 * @method Articles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articles[]    findAll()
 * @method Articles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, Articles::class);
    }

    public function save(Articles $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Articles $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    * @return Articles[] Returns an array of Articles objects
    */
   public function paginationQuery()
   {
       return $this->createQueryBuilder('a')->where('a.isPublished = 1')
           ->orderBy('a.id', 'ASC')
           ->getQuery()
       ;
   }

    /**
     * 
     * @param int $page
     * @return PaginationInterface
     */
    public function findArticleByCategory(int $page, ?Categories $categories = null): PaginationInterface
    {
        $data = $this->createQueryBuilder('a')
            ->select('c', 'a')
            ->join('a.categories', 'c');

        
        if(isset($categories))
        {
            $data = $data
                ->where('c.id LIKE :categories')
                ->setParameter('categories', $categories->getId());
        }
        
        $data->getQuery()
        ->getResult();

        $article = $this->paginatorInterface->paginate($data, $page, 6);
        
        // set an array of custom parameters
        $article->setCustomParameters([
            'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination and foundation_v6_pagination)
            'size' => 'medium', # small|large (for template: twitter_bootstrap_v4_pagination)
        ]);

        return $article;
    }

//    /**
//     * @return Articles[] Returns an array of Articles objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Articles
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
