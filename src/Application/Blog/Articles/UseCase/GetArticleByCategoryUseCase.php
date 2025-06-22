<?php

namespace App\Application\Blog\Articles\UseCase;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\Blog\Entity\Categories;
use App\Domain\Blog\Repository\ArticlesRepositoryInterface;

class GetArticleByCategoryUseCase
{
    public function __construct(
        private ArticlesRepositoryInterface $articlesRepository,
        private PaginatorInterface $paginator
    ) {}

    public function execute(Categories $category, Request $request): mixed
    {
        $pagination = $this->articlesRepository->findArticleByCategory(
            $request->query->getInt('page', 1),
            $category
        );

        return $pagination;
    }
}

