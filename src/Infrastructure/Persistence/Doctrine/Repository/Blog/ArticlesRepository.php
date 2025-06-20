<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Blog;


use App\Domain\Blog\Repository\ArticlesRepositoryInterface;
use Doctrine\ORM\Query;
use App\Domain\Blog\Entity\Articles;
use App\Domain\Blog\Entity\Categories;
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
class ArticlesRepository extends ServiceEntityRepository implements ArticlesRepositoryInterface
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, Articles::class);
    }

    public function save(Articles $articles): void
    {
        $this->getEntityManager()->persist($articles);
        $this->getEntityManager()->flush();
    }

    public function remove(Articles $articles): void
    {
        $this->getEntityManager()->remove($articles);
        $this->getEntityManager()->flush();
    }


   /**
    * Summary of paginationQuery
    * @return Query
    */
   public function paginationQuery(): Query
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
}
