<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Blog;

use App\Domain\Blog\Entity\Categories;
use App\Domain\Blog\Repository\CategoriesRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Categories>
 *
 * @method Categories|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categories|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categories[]    findAll()
 * @method Categories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriesRepository extends ServiceEntityRepository implements CategoriesRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categories::class);
    }

    public function save(Categories $categories): void
    {
        $this->getEntityManager()->persist($categories);
        $this->getEntityManager()->flush();

    }

    public function remove(Categories $categories): void
    {
        $this->getEntityManager()->remove($categories);
        $this->getEntityManager()->flush();
    }

    public function getAllCategories(): array
    {
        return $this->findAll();
    }

}
