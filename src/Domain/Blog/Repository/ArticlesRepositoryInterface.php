<?php

namespace App\Domain\Blog\Repository;

use Doctrine\ORM\Query;
use App\Domain\Blog\Entity\Categories;
use Knp\Component\Pager\Pagination\PaginationInterface;


interface ArticlesRepositoryInterface
{
    public function findArticleByCategory(int $page, Categories $categories): PaginationInterface;
    
    public function paginationQuery(): Query;
}