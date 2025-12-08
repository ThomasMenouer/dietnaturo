<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Blog;



use App\Domain\Blog\Entity\InstagramPost;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Blog\Repository\InstagramPostRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<InstagramPost>
 */
class InstagramPostRepository extends ServiceEntityRepository implements InstagramPostRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InstagramPost::class);
    }

    /**
     * Retourne une liste paginée des posts Instagram.
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function findPaginated(int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;

        return $this->createQueryBuilder('p')
            ->orderBy('p.timestamp', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère un post Instagram par son ID.
     * @param int $id
     * @return object|null
     */
    public function getPostById(int $id): ?InstagramPost
    {
        return $this->find($id);
    }

    /**
     * Compte le nombre total de posts Instagram.
     * @return int
     */
    public function countAll(): int
    {
        return (int) $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Récupère la date de la dernière actualisation des liens médias
     * @return ?\DateTimeImmutable
     */
    public function getLastRefreshedAt(): ?\DateTimeImmutable
    {
        $post = $this->findOneBy([], ['lastRefreshedAt' => 'DESC']);

        return $post ? $post->getLastRefreshedAt() : null;
    }
}
